<?php
   function conecta(){
	$conexion = new PDO("mysql:host=localhost;dbname=PROYECTO","Gerry","Gerry123!");	
	return $conexion;
}
?>
