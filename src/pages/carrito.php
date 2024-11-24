<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'cantidad')) : 0;

if (!isset($_SESSION['user'])) {
  header("Location: /Proyectos/gestion_restaurante/index.php");
  exit();
}

$user = $_SESSION['user'];

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

  <header class="container-fluid pt-3 pb-3 d-flex flex-row justify-content-center gap-4 align-items-center shadow-sm text-white"
    style="background-color: #6a329f;">
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
    <a href="/Proyectos/gestion_restaurante/src/auth/logout.php" class="btn text-black" style="background-color: #b4a7d6;">Cerrar
      Sesión</a>
  </header>

  <main class="content flex-grow-1 m-4">
    <h1>Carrito de Compras</h1>

    <?php if (empty($_SESSION['cart'])): ?>
      <p>No tienes productos en tu carrito.</p>
    <?php else: ?>
      <div class="container mt-5">
        <div class="row">
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
              <div class='col-md-4 mb-4'>
                <div class='card'>
                  <div class='card-body'>
                    <h5 class='card-title'>{$nombre}</h5>
                    <p class='card-text'>{$descripcion}</p>
                    <p><strong>Cantidad:</strong> {$cantidad}</p>
                  </div>
                  <div class='card-footer'>
                    <form action='/Proyectos/gestion_restaurante/src/cart/eliminaCarrito.php' method='POST'>
                      <input type='hidden' name='codigoProducto' value='{$codigoProducto}'>
                      <button type='submit' class='btn btn-danger btn-sm'>Eliminar del carrito</button>
                    </form>
                  </div>
                </div>
              </div>";
            }
          }

          echo "</div>";

          if ($total > 0) {
            echo "
            <div class='mt-4'>
              <a href='/Proyectos/gestion_restaurante/src/pages/proceder_pago.php' class='btn btn-success'>Proceder al pago</a>
            </div>";
          }

          ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="mt-4">
      <form action="/Proyectos/gestion_restaurante/src/cart/vaciarCarrito.php" method="POST">
        <button type="submit" class="btn btn-danger">Vaciar carrito</button>
      </form>
    </div>
  </main>

  <footer class="container-fluid d-flex justify-content-center align-items-center pt-3 pb-3 shadow-sm text-white"
    style="background-color: #6a329f;">
    <a href="https://github.com/PinkBlure" class="text-white text-decoration-none">@PinkBlure</a>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
