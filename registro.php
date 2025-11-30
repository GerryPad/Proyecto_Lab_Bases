<?php
	include "/var/www/gerardopadiula/proyecto/funciones.php";

	$mensaje="";
// Ejemplo simple de manejo del formulario (solo demostración)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $domicilio = $_POST['domicilio'];
    $password = $_POST['password'];

    newRegistro($nombre, $apellido, $correo, $telefono, $domicilio, $password);

    $mensaje = "Registro correcto";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body {
            background-color: #1e1e1e;
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-box {
            background-color: #2c2c2c;
            padding: 25px;
            border-radius: 10px;
            width: 330px;
            box-shadow: 0 0 10px #000;
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-box input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
        }

        .btn {
            background-color: #0066ff;
            color: white;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0052cc;
        }

        .login {
            text-align: center;
            margin-top: 10px;
        }

        .login a {
            color: #66aaff;
            text-decoration: none;
        }
	
	.mensaje{
	    margin-top: 15px;
	    color: lightgreen;
	    text-align: center;
	    font-size: 16px;
	    font-weight: bold;
	}
    </style>
</head>
<body>

<div class="register-box">
    <h2>Registro</h2>

    <form method="POST">

        <input type="text" name="nombre" placeholder="Nombre" required>

        <input type="text" name="apellido" placeholder="Apellido" required>

        <input type="email" name="correo" placeholder="Correo electrónico" required>

        <input type="tel" name="telefono" placeholder="Teléfono" required>

        <input type="text" name="domicilio" placeholder="Domicilio" required>

        <input type="password" name="password" placeholder="Contraseña" required>

        <input type="submit" value="Registrarse" class="btn">
    </form>

	<?php if(!empty ($mensaje)) : ?>
		<p class="mensaje"><?=$mensaje ?></p>
	<?php endif; ?>

    <div class="login">
        <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>
    </div>
</div>

</body>
</html>
