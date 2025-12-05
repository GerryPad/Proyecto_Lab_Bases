<?php
include "funciones.php"; 
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$nombreCliente = isset($input['cliente']) ? trim($input['cliente']) : '';
$nombreEmpleado = isset($input['empleado']) ? trim($input['empleado']) : '';
$carrito = isset($input['carrito']) ? $input['carrito'] : [];

$response = ["ok" => false, "mensaje" => ""];

try {
    $pdo = conecta();
    $pdo->beginTransaction();

    if (empty($nombreCliente)) {
        throw new Exception("El campo de cliente no puede estar vacío.");
    }

    $stmtC = $pdo->prepare("SELECT id_usuario FROM usuario WHERE nombre = ?");
    $stmtC->execute([$nombreCliente]);
    $idCliente = $stmtC->fetchColumn();

    if (!$idCliente) {
        throw new Exception("El cliente '$nombreCliente' no existe en la base de datos.");
    }

    $idEmpleado = 1; 
    if (!empty($nombreEmpleado)) {
        $stmtE = $pdo->prepare("SELECT id_empleado FROM empleado WHERE nombre = ?");
        $stmtE->execute([$nombreEmpleado]);
        $idEmpleado = $stmtE->fetchColumn();

        if (!$idEmpleado) {
            throw new Exception("El empleado '$nombreEmpleado' no existe en la base de datos.");
        }
    }

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

    $sql = "INSERT INTO compra (cliente, fecha_venta, id_empleado) VALUES (?, NOW(), ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idCliente, $idEmpleado]);
    
    $idCompra = $pdo->lastInsertId();

    $stmtDetalle = $pdo->prepare("INSERT INTO libro_compra (id_libro, id_compra) VALUES (?, ?)");
    $stmtLibro = $pdo->prepare("SELECT id_libro FROM libro WHERE titulo = ?");

    foreach ($carrito as $titulo => $datosLibro) {
        $cantidad = isset($datosLibro['qty']) ? (int)$datosLibro['qty'] : 1;
        
        $stmtLibro->execute([$titulo]);
        $idLibro = $stmtLibro->fetchColumn();

        if ($idLibro) {
            for ($i = 0; $i < $cantidad; $i++) {
                $stmtDetalle->execute([$idLibro, $idCompra]);
            }
            
            $stockActualizado = descontarStockPorTitulo($titulo, $cantidad, $pdo);
            if (!$stockActualizado) {
                throw new Exception("Error al actualizar el stock del libro '$titulo'.");
            }
        } else {
            throw new Exception("No se encontró el libro '$titulo' en la base de datos.");
        }
    }

    $pdo->commit(); 
    $response["ok"] = true;
    $response["id_compra"] = $idCompra;

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $response["mensaje"] = $e->getMessage();
}

echo json_encode($response);
?>
