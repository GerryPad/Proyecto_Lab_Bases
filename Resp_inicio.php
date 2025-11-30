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
    <label for="categoria">Categoría:</label>
    <select id="categoria">
        <option value="">Seleccionar</option>
        <option>Fantasía</option>
        <option>Suspenso</option>
        <option>Ciencia ficción</option>
        <option>Romance</option>
        <option>Terror</option>
    </select>
</div>

<!-- Imágenes de libros -->
<div class="contenedor-libros">

    <!-- LIBRO 1 -->
    <div class="libro">
        <button class="plus-btn" onclick="mostrar('info1')">+</button>
        <img src="https://covers.openlibrary.org/b/id/7984916-L.jpg" alt="Libro 1">
        <p>El Hobbit</p>

        <div class="info-box" id="info1">
            <span class="cerrar" onclick="cerrar('info1')">X</span>
            <p><strong>Año:</strong> 1937</p>
            <p><strong>Autor:</strong> J.R.R. Tolkien</p>
            <p><strong>Editorial:</strong> Allen & Unwin</p>
            <p>Un clásico de fantasía sobre la aventura de Bilbo Bolsón.</p>
        </div>
    </div>

    <!-- LIBRO 2 -->
    <div class="libro">
        <button class="plus-btn" onclick="mostrar('info2')">+</button>
        <img src="https://covers.openlibrary.org/b/id/8228691-L.jpg" alt="Libro 2">
        <p>1984</p>

        <div class="info-box" id="info2">
            <span class="cerrar" onclick="cerrar('info2')">X</span>
            <p><strong>Año:</strong> 1949</p>
            <p><strong>Autor:</strong> George Orwell</p>
            <p><strong>Editorial:</strong> Secker & Warburg</p>
            <p>Una novela distópica sobre vigilancia y control del estado.</p>
        </div>
    </div>

    <!-- LIBRO 3 -->
    <div class="libro">
        <button class="plus-btn" onclick="mostrar('info3')">+</button>
        <img src="https://covers.openlibrary.org/b/id/10523358-L.jpg" alt="Libro 3">
        <p>El Principito</p>

        <div class="info-box" id="info3">
            <span class="cerrar" onclick="cerrar('info3')">X</span>
            <p><strong>Año:</strong> 1943</p>
            <p><strong>Autor:</strong> Antoine de Saint-Exupéry</p>
            <p><strong>Editorial:</strong> Reynal & Hitchcock</p>
            <p>Una historia sobre la inocencia, amistad y ver con el corazón.</p>
        </div>
    </div>

    <!-- LIBRO 4 -->
    <div class="libro">
        <button class="plus-btn" onclick="mostrar('info4')">+</button>
        <img src="https://covers.openlibrary.org/b/id/11244644-L.jpg" alt="Libro 4">
        <p>Dune</p>

        <div class="info-box" id="info4">
            <span class="cerrar" onclick="cerrar('info4')">X</span>
            <p><strong>Año:</strong> 1965</p>
            <p><strong>Autor:</strong> Frank Herbert</p>
            <p><strong>Editorial:</strong> Chilton Books</p>
            <p>Una épica historia política y ecológica en el desierto de Arrakis.</p>
        </div>
    </div>

    <!-- LIBRO 5 -->
    <div class="libro">
        <button class="plus-btn" onclick="mostrar('info5')">+</button>
        <img src="https://covers.openlibrary.org/b/id/11053261-L.jpg" alt="Libro 5">
        <p>It</p>

        <div class="info-box" id="info5">
            <span class="cerrar" onclick="cerrar('info5')">X</span>
            <p><strong>Año:</strong> 1986</p>
            <p><strong>Autor:</strong> Stephen King</p>
            <p><strong>Editorial:</strong> Viking Press</p>
            <p>Una novela de terror sobre un mal que despierta cada 27 años.</p>
        </div>
    </div>

</div>

</body>
</html>
