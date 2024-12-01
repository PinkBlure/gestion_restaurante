<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../db/database_functions.php';

if (!isset($_SESSION['user'])) {
  header("Location: /Proyectos/gestion_restaurante/index.php");
  exit();
}

$user = $_SESSION['user'];

$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'cantidad')) : 0;

if (isset($_GET['codigo'])) {
  $codigoCategoria = htmlspecialchars($_GET['codigo']);
} else {
  die("No se proporcionó un código de categoría.");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos de la categoría</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .content {
      min-height: 100vh;
    }
  </style>
</head>

<body class="d-flex flex-column">

  <<header class="container-fluid pt-3 pb-3 d-flex flex-row justify-content-center gap-4 align-items-center shadow-sm text-white"
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
    <a href="/Proyectos/gestion_restaurante/src/pages/pedidos.php" class="btn text-black" style="background-color: #b4a7d6;">Pedidos</a>
    <a href="/Proyectos/gestion_restaurante/src/auth/logout.php" class="btn text-black" style="background-color: #b4a7d6;">Cerrar
      Sesión</a>
  </header>

  <main class="content m-auto" style="max-width: 80%; padding: 20px;">
    <?php
    $conn = createConnection();

    if ($conn === null) {
      echo "Fallo en la conexión.";
      exit();
    }

    try {
      $stmt = $conn->prepare("SELECT Nombre FROM Categoria WHERE Codigo = :codigo");
      $stmt->bindParam(':codigo', $codigoCategoria, PDO::PARAM_INT);
      $stmt->execute();
      $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($categoria) {
        echo "<h1 class='text-center mb-4'>Productos de la categoría: <strong>" . htmlspecialchars($categoria['Nombre']) . "</strong></h1>";
      }
    } catch (PDOException $ex) {
      echo "Error al obtener la categoría: " . htmlspecialchars($ex->getMessage());
    }

    $productos = seleccionarProductos($conn, $codigoCategoria);

    if ($productos) {
      echo "<div class='container'>";
      echo "<div class='row g-4'>";

      foreach ($productos as $producto) {
        $codigo = htmlspecialchars($producto['Codigo']);
        $nombre = htmlspecialchars($producto['Nombre']);
        $descripcion = htmlspecialchars($producto['Descripcion']);
        $peso = htmlspecialchars($producto['Peso']);
        $cantidadStock = htmlspecialchars($producto['CantidadStock']);

        echo "
        <div class='col-12 col-md-6 col-lg-4'>
          <div class='card h-100 shadow-sm'>
            <div class='card-body text-center'>
              <h5 class='card-title mb-3'>{$nombre}</h5>
              <p class='card-text'>{$descripcion}</p>
              <p><strong>Peso:</strong> {$peso} g</p>
              <p><strong>Stock:</strong> {$cantidadStock} unidades</p>
              <small class='text-muted'>Código: {$codigo}</small>
            </div>
            <div class='card-footer text-center'>
              <form action='/Proyectos/gestion_restaurante/src/cart/agregarCarrito.php' method='POST' class='d-flex flex-column align-items-center'>
                <input type='hidden' name='codigoProducto' value='{$codigo}'>
                <input type='hidden' name='codigoCategoria' value='{$codigoCategoria}'>
                <div class='mb-2'>
                  <label for='cantidad{$codigo}' class='form-label'><strong>Cantidad:</strong></label>
                  <input type='number' id='cantidad{$codigo}' name='cantidad' class='form-control' value='1' min='1' max='{$cantidadStock}' required style='width: 80px;'>
                </div>
                <button type='submit' class='btn btn-primary btn-sm'>Añadir al carrito</button>
              </form>
            </div>
          </div>
        </div>";
      }

      echo "</div>";
      echo "</div>";
    } else {
      echo "<p class='text-center'>No se encontraron productos para esta categoría.</p>";
    }
    ?>
  </main>

  <footer class="container-fluid d-flex justify-content-center align-items-center pt-3 pb-3 shadow-sm text-white"
    style="background-color: #6a329f;">
    <a href="https://github.com/PinkBlure" class="text-white text-decoration-none">@PinkBlure</a>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
