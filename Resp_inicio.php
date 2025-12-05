<?php
	include "/var/www/gerardopadiula/proyecto/funciones.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Librería APG</title>
    <style>
        body {
            background-color: #1e1e1e;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        /* Barra superior */
        .header {
            background-color: #2b2b2b;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .titulo {
            font-size: 24px;
            font-weight: bold;
        }

        /* Botones de la parte superior */
        .right-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-top {
            background-color: #0066ff;
            padding: 10px 15px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-top:hover {
            background-color: #004dcc;
        }

        /* Menú desplegable */
        .menu {
            margin: 20px;
        }

        select {
            padding: 10px;
            background-color: #2c2c2c;
            color: white;
            border: 1px solid #555;
            border-radius: 5px;
        }

        /* Galería de libros */
        .contenedor-libros {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .libro {
            position: relative;
            background-color: #2a2a2a;
            padding: 10px;
            margin: 10px;
            border-radius: 8px;
            width: 150px;
            text-align: center;
        }

        .libro img {
            width: 100%;
            height: 200px;
            border-radius: 5px;
            object-fit: cover;
        }

        /* Botón + */
        .plus-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: #007bff;
            border: none;
            padding: 5px 8px;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            cursor: pointer;
        }

        /* Cuadro flotante */
        .info-box {
            display: none;
            position: absolute;
            top: 40px;
            left: 0;
            width: 100%;
            background-color: #333;
            padding: 10px;
            border-radius: 8px;
            z-index: 10;
            font-size: 13px;
        }

        .cerrar {
            color: #ff5555;
            font-weight: bold;
            float: right;
            cursor: pointer;
        }
    </style>

    <script>
        function mostrar(id) {
            document.getElementById(id).style.display = "block";
        }

        function cerrar(id) {
            document.getElementById(id).style.display = "none";
        }
    </script>

</head>
<body>

<!-- Barra superior -->
<div class="header">
    <div class="titulo">Librería APG</div>

    <div class="right-buttons">
        <a href="venta.php" class="btn-top">Venta</a>
        <a href="login.php" class="btn-top">Cerrar sesión</a>
    </div>
</div>

<!-- Menú de categorías -->
<div class="menu">
    <form action="" method="GET">
        <label for="categoria" style="color:white;">Categoría:</label>
        
        <select name="categoria" id="categoria" onchange="this.form.submit()">
            <option value="todos">Mostrar todos</option>
            
            <option value="1" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '1') ? 'selected' : '' ?>>Clásicos</option>
            <option value="2" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '2') ? 'selected' : '' ?>>Romance</option>
            <option value="3" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '3') ? 'selected' : '' ?>>Terror</option>
            <option value="4" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '4') ? 'selected' : '' ?>>Ciencia Ficción</option>
            <option value="5" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '5') ? 'selected' : '' ?>>Aventura</option>
            <option value="7" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '7') ? 'selected' : '' ?>>Novela Negra</option>
            <option value="8" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '8') ? 'selected' : '' ?>>Infantil</option>
	    <option value="9" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '9') ? 'selected' : '' ?>>Autoayuda</option>
            <option value="10" <?= (isset($_GET['categoria']) && $_GET['categoria'] == '10') ? 'selected' : '' ?>>Arte</option>
            </select>
    </form>
</div>

<!-- Imágenes de libros -->
<div class="contenedor-libros">
<?php
    // 1. CORRECCIÓN: Usamos 'categoria' para coincidir con el <select name="categoria"> del HTML
    $filtro = isset($_GET['categoria']) ? $_GET['categoria'] : null;
    
    // CORRECCIÓN: Agregada la comilla de cierre que faltaba en "todos"
    if ($filtro == "todos") $filtro = null;

    // 2. Llamamos a la función
    $libros = mostrarLibros($filtro);

    // 3. Verificamos si hay datos
    if ($libros && count($libros) > 0) {

        foreach ($libros as $libro) {
            $id = $libro['id_libro'];
            $nombre = $libro['titulo'];
	    $nombre_autor = $libro['nombre_autor'];         // Ya no sale el ID, sale el Nombre
	    $nombre_editorial = $libro['nombre_editorial'];
	    $anio = isset($libro['year_publicacion']) ? $libro['year_publicacion'] : 'S/F';    
?>
<div class="libro" style="display:inline-block; margin:15px; width: 160px; vertical-align: top; text-align:center; position: relative;">
                <button class="plus-btn" onclick="mostrar('info<?= $id ?>')" style="float:right; cursor:pointer;">+</button>
          <p style="color: white; font-weight: bold; margin-top: 5px; font-size: 14px;"><?= $nombre ?></p>
            <div class="info-box" id="info<?= $id ?>">
               <span class="cerrar" onclick="cerrar('info<?= $id ?>')">X</span>
               <p><strong>Año:</strong> <?= $anio ?></p>
               <p><strong>Autor:</strong> <?= $nombre_autor ?></p>
               <p><strong>Editorial:</strong> <?= $nombre_editorial ?></p>
           </div>
        </div>
    <?php 
        } // Fin del foreach
    } else {
        // Mensaje si no hay libros
        echo "<h3 style='color:white; padding:20px;'>No se encontraron libros para la categoría seleccionada (ID: $filtro).</h3>";
    }
?>
</div>
</body>
</html>
	
