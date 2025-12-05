<?php
include "/var/www/gerardopadiula/proyecto/funciones.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $correo = $_POST["correo"] ?? '';
    $password = $_POST["password"] ?? '';

    $usuario = inicioSesion($correo);

    if ($usuario) {
        if ($password === $usuario['password']) {

            $_SESSION['correo'] = $usuario['correo'];

            header("Location: inicio.php");
            exit;

        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "El correo no existe";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            background:#1e1e1e;
            color:white;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            font-family:Arial;
        }
        .login-box {
            background:#2c2c2c;
            padding:25px;
            width:300px;
            border-radius:10px;
        }
        input {
            width:100%;
            padding:10px;
            margin:8px 0;
            border-radius:5px;
            border:none;
        }
        .btn {
            background:#0066ff;
            color:white;
            cursor:pointer;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2> Iniciar Sesión</h2>

    <form method="POST">
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="submit" class="btn" value="Entrar">
    </form>

    <?php if (!empty($error)): ?>
        <p style="color:red;text-align:center"><?= $error ?></p>
    <?php endif; ?>

    <p style="text-align:center">
        <a href="registro.php" style="color:#66aaff">Registrarse</a>
    </p>
</div>

</body>
</html>
