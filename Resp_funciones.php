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

function mostrarLibros(){
	$stmt = conecta()->prepare(
	"SELECT * FROM libro"
);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function infoLibro(){
        $stmt = conecta()->prepare(
        "SELECT l.titulo, i.precio_venta  from libro l inner join informacion i on l.informacion=i.id_informacion"
);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function stock(){
	$stmt = connecta()->prepare(
	"SELECT i.stock FROM informacion i INNER JOIN libro l ON i.id_informacion = l.id_informacion");
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}
?>
