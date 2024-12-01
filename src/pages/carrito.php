<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'cantidad')) : 0;
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

if (!isset($user)) {
    header("Location: /Proyectos/gestion_restaurante/index.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/Proyectos/gestion_restaurante/src/db/database_functions.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito de Compras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    .content {
      min-height: 100vh;
    }
  </style>
</head>

<body class="d-flex flex-column">
  <header class="container-fluid pt-3 pb-3 d-flex flex-row justify-content-center gap-4 align-items-center shadow-sm text-white" style="background-color: #6a329f;">
    <h3>Usuario: <?php echo htmlspecialchars($user['email']); ?></h3>
    <a href="/Proyectos/gestion_restaurante/src/pages/carrito.php" class="btn text-black position-relative" style="background-color: #b4a7d6;">
      <i class="bi bi-cart"></i> Carrito
      <?php if ($cartCount > 0): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          <?php echo $cartCount; ?>
        </span>
      <?php endif; ?>
    </a>
    <a href="/Proyectos/gestion_restaurante/src/pages/lista.php" class="btn text-black" style="background-color: #b4a7d6;">Categorías</a>
    <a href="/Proyectos/gestion_restaurante/src/pages/pedidos.php" class="btn text-black" style="background-color: #b4a7d6;">Pedidos</a>
    <a href="/Proyectos/gestion_restaurante/src/auth/logout.php" class="btn text-black" style="background-color: #b4a7d6;">Cerrar Sesión</a>
  </header>

  <main class="content m-auto" style="max-width: 80%; padding: 20px;">
    <h1 class="text-center mb-4">Carrito de Compras</h1>

    <?php if (isset($_SESSION['pedido_message'])): ?>
      <div class="alert alert-info text-center">
        <?php echo $_SESSION['pedido_message']; ?>
      </div>
      <?php unset($_SESSION['pedido_message']); ?>
    <?php endif; ?>

    <?php if (empty($_SESSION['cart'])): ?>
      <p class="text-center">No tienes productos en tu carrito.</p>
    <?php else: ?>
      <div class="container">
        <div class="row g-4">
          <?php
          $conn = createConnection();
          if ($conn === null) {
            echo "Fallo en la conexión.";
            exit();
          }

          $total = 0;
          foreach ($_SESSION['cart'] as $codigoProducto => $producto) {
            $stmt = $conn->prepare("SELECT * FROM Producto WHERE Codigo = :codigo");
            $stmt->bindParam(':codigo', $codigoProducto, PDO::PARAM_INT);
            $stmt->execute();
            $productoDetalles = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($productoDetalles) {
              $nombre = htmlspecialchars($productoDetalles['Nombre']);
              $descripcion = htmlspecialchars($productoDetalles['Descripcion']);
              $cantidad = $producto['cantidad'];

              echo "
              <div class='col-12 col-md-6 col-lg-4'>
                <div class='card h-100 shadow-sm'>
                  <div class='card-body text-center'>
                    <h5 class='card-title mb-3'>{$nombre}</h5>
                    <p class='card-text'>{$descripcion}</p>
                    <p><strong>Cantidad:</strong> {$cantidad}</p>
                  </div>
                  <div class='card-footer'>
                    <form action='/Proyectos/gestion_restaurante/src/cart/eliminaCarrito.php' method='POST' class='d-flex flex-column align-items-center'>
                      <input type='hidden' name='codigoProducto' value='{$codigoProducto}'>
                      <div class='mb-2 d-flex flex-column align-items-center'>
                        <label for='cantidadEliminar{$codigoProducto}' class='form-label mb-2'><strong>Eliminar cantidad:</strong></label>
                        <input type='number' id='cantidadEliminar{$codigoProducto}' name='cantidadEliminar' class='form-control w-auto' min='1' max='{$cantidad}' value='1' required>
                      </div>
                      <button type='submit' class='btn btn-danger btn-sm'>Eliminar del carrito</button>
                    </form>
                  </div>
                </div>
              </div>";
            }
          }
          ?>
        </div>

        <div class="mt-4 text-center">
          <a href="/Proyectos/gestion_restaurante/src/cart/realizarPedido.php" class="btn btn-success" id="realizarPedido">Realizar un pedido</a>
        </div>

        <div class="mt-4 text-center">
          <form action="/Proyectos/gestion_restaurante/src/cart/vaciarCarrito.php" method="POST">
            <button type="submit" class="btn btn-danger">Vaciar carrito</button>
          </form>
        </div>
      </div>
    <?php endif; ?>
  </main>

  <footer class="container-fluid d-flex justify-content-center align-items-center pt-3 pb-3 shadow-sm text-white" style="background-color: #6a329f;">
    <a href="https://github.com/PinkBlure" class="text-white text-decoration-none">Desarrollado por PinkBlure</a>
  </footer>
</body>

</html>
