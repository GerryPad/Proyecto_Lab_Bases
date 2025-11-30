<?php
	include "/var/www/gerardopadiula/proyecto/funciones.php";
	if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['carrito'])) {

    $carrito = json_decode($_POST['carrito'], true);

    if ($carrito && count($carrito) > 0) {

        foreach ($carrito as $titulo => $detalle) {
            $ok = descontarStockPorTitulo($titulo, $detalle['qty']);

            }

    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas - Librería APG</title>
    <style>

	/* Estilos para el contenedor superior */
.top-controls {
    display: flex;
    gap: 20px; /* Espacio entre los dos campos */
    margin-bottom: 20px;
    align-items: center;
}

/* Agrupamos label e input para que se ordenen bien */
.input-group {
    display: flex;
    flex-direction: column; /* Pone el label arriba del input */
}

/* Estilo de las etiquetas */
.top-controls label {
    color: #ccc;
    margin-bottom: 5px;
    font-size: 14px;
}

/* Estilo de los inputs (cajas de texto) */
.top-controls input {
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #555;
    background-color: #333;
    color: white;
    width: 200px; /* Ancho fijo para que se vean uniformes */
}

        body {
            background-color: #1e1e1e;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
        }

        .left-panel {
            width: 70%;
            padding: 20px;
        }

        .right-panel {
            width: 30%;
            background-color: #262626;
            padding: 20px;
            border-left: 2px solid #444;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .header {
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select, input {
            padding: 8px;
            background-color: #2c2c2c;
            color: white;
            border: 1px solid #555;
            border-radius: 5px;
        }

        .book {
            background-color: #2a2a2a;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .add-btn {
            background-color: #0066ff;
            padding: 8px 12px;
            border-radius: 6px;
            color: white;
            cursor: pointer;
        }

        .remove-btn {
            background-color: #d9534f;
            padding: 4px 8px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            padding: 8px;
            background-color: #333;
            border-radius: 5px;
        }

        .total-box {
            margin-top: 30px;
            font-size: 22px;
            font-weight: bold;
            border-top: 1px solid #666;
            padding-top: 20px;
        }
    </style>
</head>

<body>

    <!-- PANEL IZQUIERDO -->
    <div class="left-panel">

        <div class="top-controls">
    <div class="input-group">
        <label for="clienteNombre">Cliente:</label>
        <input type="text" id="clienteNombre" name="cliente" placeholder="Nombre del cliente" required>
    </div>

    <div class="input-group">
        <label for="empleadoNombre">Empleado:</label>
        <input type="text" id="empleadoNombre" name="empleado" placeholder="Nombre del empleado" required>
    </div>
</div>

        <div class="header">Libros</div>
<?php
// ... tus includes ...

// 1. Capturamos la categoría de la URL (si existe)
$categoria_seleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : null;

// 2. Llamamos a TU función existente, pasándole el filtro
$libros = infoLibro($categoria_seleccionada);
?>

<div class="filtros">
    <form action="" method="GET">
        <label>Categoría:</label>
        <select name="categoria" onchange="this.form.submit()">
            <option value="">Todas</option>
            <option value="1" <?php if($categoria_seleccionada == '1') echo 'selected'; ?>>Clasicos</option>
            <option value="2" <?php if($categoria_seleccionada == '2') echo 'selected'; ?>>Romance</option>
            <option value="3" <?php if($categoria_seleccionada == '3') echo 'selected'; ?>>Terror</option>
            <option value="4" <?php if($categoria_seleccionada == '4') echo 'selected'; ?>>Ciencia Ficcion</option>
            <option value="5" <?php if($categoria_seleccionada == '5') echo 'selected'; ?>>Aventura</option>
            <option value="6" <?php if($categoria_seleccionada == '6') echo 'selected'; ?>>Biografia</option>
            <option value="7" <?php if($categoria_seleccionada == '7') echo 'selected'; ?>>Novela Negra</option>
            <option value="8" <?php if($categoria_seleccionada == '8') echo 'selected'; ?>>Infantil</option>
            <option value="9" <?php if($categoria_seleccionada == '9') echo 'selected'; ?>>Autoayuda</option>
            <option value="10" <?php if($categoria_seleccionada == '10') echo 'selected'; ?>>Arte</option>

            </select>
    </form>
</div>

<div class="book-container">
    <?php if (count($libros) > 0): ?>
        <?php foreach ($libros as $libro): ?>
            
            <div class="book-card">
                <span>
                    <?php echo $libro['titulo']; ?> — $<?php echo $libro['precio_venta']; ?>
                </span>

                <button class="add-btn" 
                    onclick="addToCart('<?php echo $libro['titulo']; ?>', <?php echo $libro['precio_venta']; ?>)">
                    Añadir
                </button>
            </div>

        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay libros disponibles en esta categoría.</p>
    <?php endif; ?>
</div>
    </div>


    <!-- PANEL DERECHO -->
    <div class="right-panel">
        <h2>Carrito de compra</h2>

        <div id="lista-carrito"></div>

        <div class="total-box">
            TOTAL: $<span id="total">0</span>
        </div>

<button onclick="efectuarVenta()" class="checkout-btn">Efectuar venta</button>
    </div>


    <script>
        let total = 0;

        // Carrito como objeto
        let carrito = {};

        
        function addToCart(name, price) {

            // Si no existe, agregarlo
            if (!carrito[name]) {
                carrito[name] = { price: price, qty: 1 };
            } else {
                carrito[name].qty++;
            }

            total += price;
            actualizarCarrito();
        }

        function removeItem(name) {
            if (carrito[name]) {
                carrito[name].qty--;
                total -= carrito[name].price;

                if (carrito[name].qty <= 0) {
                    delete carrito[name];
                }
            }

            if (total < 0) total = 0;
            actualizarCarrito();
        }

        function actualizarCarrito() {
            const lista = document.getElementById("lista-carrito");
            lista.innerHTML = "";

            for (let libro in carrito) {
                const item = document.createElement("div");
                item.className = "cart-item";

                item.innerHTML = `
                    <span>${libro} — $${carrito[libro].price}  <strong>x${carrito[libro].qty}</strong></span>
                    <button class="remove-btn" onclick="removeItem('${libro}')">Quitar</button>
                `;

                lista.appendChild(item);
            }

            document.getElementById("total").textContent = total;
        }
    // ✅ FUNCIÓN PUNTO 2 (VA ACÁ)
    function efectuarVenta() {

        if (Object.keys(carrito).length === 0) {
            alert("El carrito está vacío");
            return;
        }

        const form = document.createElement("form");
        form.method = "POST";
        form.action = "venta.php"; // tu archivo actual

        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "carrito";
        input.value = JSON.stringify(carrito);

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }

    </script>
</body>
</html>
