<?php
	include "/var/www/gerardopadiula/proyecto/funciones.php";
// Esto es solo un ejemplo sencillo
// Aquí validarías los datos cuando el usuario envía el formulario.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    // Validación súper básica (solo de ejemplo)
    
    if ($correo === "test@example.com" && $pass === "1234") {
        echo "<p style='color: lightgreen; text-align:center;'>Inicio de sesión exitoso.</p>";
    } else {
        echo "<p style='color: red; text-align:center;'>Correo o contraseña incorrectos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login sencillo</title>
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

        .login-box {
            background-color: #2c2c2c;
            padding: 25px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 0 10px #000;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-box input {
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

        .registro {
            text-align: center;
            margin-top: 10px;
        }

        .registro a {
            color: #66aaff;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Iniciar Sesión</h2>

    <form action="" method="POST">
        <input type="email" name="correo" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="submit" value="Iniciar Sesión" class="btn">
	<?php
	  if ($correo === "test@example.com" && $password === "1234") {
        echo "<p style='color: lightgreen; text-align:center;'>Inicio de sesión exitoso.</p>";
    } else {
        echo "<p style='color: red; text-align:center;'>Correo o contraseña incorrectos.</p>";
    }
 
	?>
    </form>

    <div class="registro">
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</div>

</body>
</html>

