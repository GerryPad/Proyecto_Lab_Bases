<?php
// Incluye tu conexión
include "funciones.php"; // Asegúrate que la ruta sea correcta
header('Content-Type: application/json');

// Recibir datos JSON
$input = json_decode(file_get_contents('php://input'), true);
$nombreCliente = $input['cliente'];
$nombreEmpleado = $input['empleado'];
$carrito = $input['carrito'];

$response = ["ok" => false, "mensaje" => ""];

try {
    $pdo = conecta();
    $pdo->beginTransaction(); // Iniciar transacción por seguridad

    // ---------------------------------------------------------
    // 1. BUSCAR ID DEL CLIENTE (Obligatorio)
    // ---------------------------------------------------------
    $stmtC = $pdo->prepare("SELECT id_usuario FROM usuario WHERE nombre = ?");
    $stmtC->execute([$nombreCliente]);
    $idCliente = $stmtC->fetchColumn();

    if (!$idCliente) {
        throw new Exception("El cliente '$nombreCliente' no existe en la base de datos.");
    }

    // ---------------------------------------------------------
    // 2. BUSCAR ID DEL EMPLEADO (Opcional/Nullable)
    // ---------------------------------------------------------
    $idEmpleado = null; // Por defecto NULL
    if (!empty($nombreEmpleado)) {
        $stmtE = $pdo->prepare("SELECT id_empleado FROM empleado WHERE nombre = ?");
        $stmtE->execute([$nombreEmpleado]);
        $idEmpleado = $stmtE->fetchColumn();

        if (!$idEmpleado) {
            throw new Exception("El empleado '$nombreEmpleado' no existe.");
        }
    }

    // ---------------------------------------------------------
    // 3. INSERTAR EN LA TABLA COMPRA
    // ---------------------------------------------------------
    // Usamos CURDATE() o NOW() para la fecha_venta
    $sql = "INSERT INTO compra (cliente, fecha_venta, id_empleado) VALUES (?, NOW(), ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idCliente, $idEmpleado]);
    
    // Obtenemos el ID de la compra recién generada
    $idCompra = $pdo->lastInsertId();

    // ---------------------------------------------------------
    // 4. INSERTAR DETALLES (LIBRO_COMPRA)
    // ---------------------------------------------------------
    // Recorremos el carrito para guardar qué libros se compraron
    $stmtDetalle = $pdo->prepare("INSERT INTO libro_compra (id_libro, id_compra) VALUES (?, ?)");
    
    // También preparamos consulta para buscar ID de libro por título
    $stmtLibro = $pdo->prepare("SELECT id_libro FROM libro WHERE titulo = ?");

    foreach ($carrito as $titulo => $datosLibro) {
        // Buscar ID del libro
        $stmtLibro->execute([$titulo]);
        $idLibro = $stmtLibro->fetchColumn();

        if ($idLibro) {
            // Guardar en libro_compra
            // Si tu tabla libro_compra tiene columna 'cantidad', agrégala al INSERT
            $stmtDetalle->execute([$idLibro, $idCompra]);
        }
    }

    $pdo->commit(); // Confirmar cambios
    $response["ok"] = true;
    $response["id_compra"] = $idCompra;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack(); // Deshacer si hubo error
    }
    $response["mensaje"] = $e->getMessage();
}

echo json_encode($response);
?>
