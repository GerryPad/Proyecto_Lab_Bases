<?php
include "/var/www/gerardopadiula/proyecto/conexion.php";

function newRegistro($nombre, $apellido, $correo, $telefono, $domicilio, $password) {
    $stmt = conecta()->prepare(
        "INSERT INTO usuario (nombre, apellido, correo, telefono, domicilio, password)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    return $stmt->execute([$nombre, $apellido, $correo, $telefono, $domicilio, $password]);
}

function inicioSesion($correo) {
    $stmt = conecta()->prepare(
        "SELECT correo, password FROM usuario WHERE correo = ?"
    );
    $stmt->execute([$correo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function mostrarLibros($id_genero = null) {
    $pdo = conecta();
	$sql = "SELECT DISTINCT l.*, a.nombre AS nombre_autor, e.nombre AS nombre_editorial, i.year_publicacion
            FROM libro l
            INNER JOIN autor a ON l.autor = a.id_autor
            INNER JOIN editorial e ON l.editorial = e.id_editorial
	    INNER JOIN informacion i ON l.informacion = i.id_informacion";

    if ($id_genero !== null && $id_genero !== "" && $id_genero !== "todos") {
        
        // Aquí agregamos tu lógica, corregí 'di_libro' por 'id_libro'
        $sql .= " INNER JOIN libro_genero lg ON l.id_libro = lg.id_libro 
                  WHERE lg.id_genero = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_genero]);
        
    } else {
        // Sin filtro, ejecutamos la consulta base
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function infoLibro($id_genero = null) {
    $pdo = conecta();

    // 1. Consulta BASE: Trae titulo y precio (Uniendo libro + informacion)
    // Usamos 'DISTINCT' por si un libro tuviera el mismo género asignado dos veces por error, que no salga repetido.
    $sql = "SELECT DISTINCT l.titulo, i.precio_venta 
            FROM libro l 
            INNER JOIN informacion i ON l.informacion = i.id_informacion";

    // 2. Si hay filtro, agregamos el JOIN a la tabla intermedia y el WHERE
    if ($id_genero != null) {
        
        // Unimos con la tabla 'libro_genero' usando el ID del libro
        $sql .= " INNER JOIN libro_genero lg ON l.id_libro = lg.id_libro 
                  WHERE lg.id_genero = ?";
                  
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_genero]);
        
    } else {
        // Si NO hay filtro (quieren ver todos), ejecutamos la consulta base sin el JOIN extra
        // para evitar duplicados si un libro tiene varios géneros.
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function descontarStockPorTitulo($titulo, $cantidad, $pdo = null) {
    // Si no se pasa una conexión, crear una nueva
    if ($pdo === null) {
        $pdo = conecta();
    }

    // Obtener información del libro y stock
    $stmt = $pdo->prepare("
        SELECT i.id_informacion, i.stock
        FROM libro l
        INNER JOIN informacion i ON l.informacion = i.id_informacion
        WHERE l.titulo = ?
        FOR UPDATE
    ");
    $stmt->execute([$titulo]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$libro) {
        return false; // Libro inexistente
    }

    if ($libro['stock'] < $cantidad) {
        return false; // Stock insuficiente
    }

    // Actualizar stock
    $nuevoStock = $libro['stock'] - $cantidad;

    $update = $pdo->prepare("
        UPDATE informacion
        SET stock = ?
        WHERE id_informacion = ?
    ");

    return $update->execute([$nuevoStock, $libro['id_informacion']]);
}

// Busca el ID del usuario por nombre (exacto)
function obtenerIdUsuario($nombre) {
    $pdo = conecta();
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE nombre = ?");
    $stmt->execute([$nombre]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado ? $resultado['id_usuario'] : false;
}

// Busca el ID del empleado por nombre (exacto)
function obtenerIdEmpleado($nombre) {
    $pdo = conecta();
    $stmt = $pdo->prepare("SELECT id_empleado FROM empleado WHERE nombre = ?");
    $stmt->execute([$nombre]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado ? $resultado['id_empleado'] : false;
}

// Busca el ID del libro por título (necesario para llenar libro_compra)
function obtenerIdLibroPorTitulo($titulo) {
    $pdo = conecta();
    $stmt = $pdo->prepare("SELECT id_libro FROM libro WHERE titulo = ?");
    $stmt->execute([$titulo]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado ? $resultado['id_libro'] : false;
}

// Verifica el stock disponible de un libro por título
function verificarStockPorTitulo($titulo, $cantidadRequerida) {
    $pdo = conecta();
    $stmt = $pdo->prepare("
        SELECT i.stock
        FROM libro l
        INNER JOIN informacion i ON l.informacion = i.id_informacion
        WHERE l.titulo = ?
    ");
    $stmt->execute([$titulo]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$resultado) {
        return ['existe' => false, 'stock' => 0];
    }
    
    return [
        'existe' => true,
        'stock' => (int)$resultado['stock'],
        'suficiente' => (int)$resultado['stock'] >= $cantidadRequerida
    ];
}

?>
