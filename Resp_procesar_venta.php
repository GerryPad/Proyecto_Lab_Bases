<?php
// Incluye tu conexión
include "funciones.php"; // Asegúrate que la ruta sea correcta
header('Content-Type: application/json');

// Recibir datos JSON
$input = json_decode(file_get_contents('php://input'), true);
$nombreCliente = isset($input['cliente']) ? trim($input['cliente']) : '';
$nombreEmpleado = isset($input['empleado']) ? trim($input['empleado']) : '';
$carrito = isset($input['carrito']) ? $input['carrito'] : [];

$response = ["ok" => false, "mensaje" => ""];

try {
    $pdo = conecta();
    $pdo->beginTransaction(); // Iniciar transacción por seguridad

    // ---------------------------------------------------------
    // 1. VALIDAR QUE EL CLIENTE NO ESTÉ VACÍO
    // ---------------------------------------------------------
    if (empty($nombreCliente)) {
        throw new Exception("El campo de cliente no puede estar vacío.");
    }

    // ---------------------------------------------------------
    // 2. BUSCAR ID DEL CLIENTE (Obligatorio - debe existir)
    // ---------------------------------------------------------
    $stmtC = $pdo->prepare("SELECT id_usuario FROM usuario WHERE nombre = ?");
    $stmtC->execute([$nombreCliente]);
    $idCliente = $stmtC->fetchColumn();

    if (!$idCliente) {
        throw new Exception("El cliente '$nombreCliente' no existe en la base de datos.");
    }

    // ---------------------------------------------------------
    // 3. BUSCAR ID DEL EMPLEADO (Opcional/Nullable)
    // ---------------------------------------------------------
    $idEmpleado = null; // Por defecto NULL
    if (!empty($nombreEmpleado)) {
        $stmtE = $pdo->prepare("SELECT id_empleado FROM empleado WHERE nombre = ?");
        $stmtE->execute([$nombreEmpleado]);
        $idEmpleado = $stmtE->fetchColumn();

        if (!$idEmpleado) {
            throw new Exception("El empleado '$nombreEmpleado' no existe en la base de datos.");
        }
    }

    // ---------------------------------------------------------
    // 4. VALIDAR STOCK DE TODOS LOS LIBROS ANTES DE PROCESAR
    // ---------------------------------------------------------
    $librosSinStock = [];
    foreach ($carrito as $titulo => $datosLibro) {
        $cantidadRequerida = isset($datosLibro['qty']) ? (int)$datosLibro['qty'] : 1;
        $infoStock = verificarStockPorTitulo($titulo, $cantidadRequerida);
        
        if (!$infoStock['existe']) {
            $librosSinStock[] = "$titulo (libro no encontrado)";
        } elseif (!$infoStock['suficiente']) {
            $librosSinStock[] = "$titulo (stock disponible: {$infoStock['stock']}, requerido: $cantidadRequerida)";
        }
    }

    if (!empty($librosSinStock)) {
        $mensaje = "No hay suficientes libros en stock:\n" . implode("\n", $librosSinStock);
        throw new Exception($mensaje);
    }

    // ---------------------------------------------------------
    // 5. INSERTAR EN LA TABLA COMPRA
    // ---------------------------------------------------------
    // Usamos CURDATE() o NOW() para la fecha_venta
    $sql = "INSERT INTO compra (cliente, fecha_venta, id_empleado) VALUES (?, NOW(), ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idCliente, $idEmpleado]);
    
    // Obtenemos el ID de la compra recién generada
    $idCompra = $pdo->lastInsertId();

    // ---------------------------------------------------------
    // 6. INSERTAR DETALLES (LIBRO_COMPRA) Y REDUCIR STOCK
    // ---------------------------------------------------------
    // Recorremos el carrito para guardar qué libros se compraron
    $stmtDetalle = $pdo->prepare("INSERT INTO libro_compra (id_libro, id_compra) VALUES (?, ?)");
    
    // También preparamos consulta para buscar ID de libro por título
    $stmtLibro = $pdo->prepare("SELECT id_libro FROM libro WHERE titulo = ?");

    foreach ($carrito as $titulo => $datosLibro) {
        $cantidad = isset($datosLibro['qty']) ? (int)$datosLibro['qty'] : 1;
        
        // Buscar ID del libro
        $stmtLibro->execute([$titulo]);
        $idLibro = $stmtLibro->fetchColumn();

        if ($idLibro) {
            // Guardar en libro_compra (insertar una vez por cada cantidad)
            for ($i = 0; $i < $cantidad; $i++) {
                $stmtDetalle->execute([$idLibro, $idCompra]);
            }
            
            // Reducir el stock en la tabla informacion (pasar $pdo para usar la misma transacción)
            $stockActualizado = descontarStockPorTitulo($titulo, $cantidad, $pdo);
            if (!$stockActualizado) {
                throw new Exception("Error al actualizar el stock del libro '$titulo'.");
            }
        } else {
            throw new Exception("No se encontró el libro '$titulo' en la base de datos.");
        }
    }

    $pdo->commit(); // Confirmar cambios
    $response["ok"] = true;
    $response["id_compra"] = $idCompra;

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack(); // Deshacer si hubo error
    }
    $response["mensaje"] = $e->getMessage();
}

echo json_encode($response);
?>
