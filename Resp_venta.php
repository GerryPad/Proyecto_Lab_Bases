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

.top-controls {
    display: flex;
    gap: 20px; 
    margin-bottom: 20px;
    align-items: center;
}

.input-group {
    display: flex;
    flex-direction: column; 
}

.top-controls label {
    color: #ccc;
    margin-bottom: 5px;
    font-size: 14px;
}

.top-controls input {
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #555;
    background-color: #333;
    color: white;
    width: 200px; 
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
	    border: none;
        }

        .remove-btn {
            background-color: #d9534f;
            padding: 4px 8px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
	    border: none;
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
        <input type="text" id="empleadoNombre" name="empleado" placeholder="Nombre del empleado">
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

    <?php if (count($libros) > 0): ?>
        <?php foreach ($libros as $libro): ?>
            
            <div class="book">
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


    <!-- PANEL DERECHO -->
    <div class="right-panel">
        <h2>Carrito de compra</h2>

        <div id="lista-carrito"></div>

        <div class="total-box">
            TOTAL: $<span id="total">0</span>
        </div>

<button type="button" onclick="efectuarVenta()" class="checkout-btn">Efectuar venta</button>
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
async function efectuarVenta() {
    // 1. Validar que hay cosas en el carrito
    if (Object.keys(carrito).length === 0) {
        alert("El carrito está vacío.");
        return;
    }

    // 2. Capturar los nombres escritos en los inputs
    const nombreCliente = document.getElementById("clienteNombre").value.trim();
    const nombreEmpleado = document.getElementById("empleadoNombre").value.trim();

    // 3. Validar que el cliente no esté vacío (según tu tabla es obligatorio)
    if (nombreCliente === "") {
        alert("Por favor, ingresa el nombre del cliente.");
        return;
    }

    // 4. Preparar el paquete de datos
    const datos = {
        cliente: nombreCliente,
        empleado: nombreEmpleado,
        carrito: carrito
    };

    try {
        // 5. Enviar a PHP usando FETCH
        const respuesta = await fetch('procesar_venta.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(datos)
        });

        const resultado = await respuesta.json();

        if (resultado.ok) {
            alert("✅ Venta realizada con éxito. ID Compra: " + resultado.id_compra);
            // Limpiar todo
            carrito = {};
            total = 0;
            actualizarCarrito();
            document.getElementById("clienteNombre").value = "";
            document.getElementById("empleadoNombre").value = "";
            document.getElementById("total").innerText = "$0";
        } else {
            alert("❌ Error: " + resultado.mensaje);
        }

    } catch (error) {
        console.error(error);
        alert("Error de conexión con el servidor.");
    }
}
    </script>
</body>
</html>
