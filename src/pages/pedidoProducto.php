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

if (!isset($_GET['id'])) {
  echo "ID del pedido no proporcionado.";
  exit();
}

$id_pedido = htmlspecialchars($_GET['id']);

$conn = createConnection();

if ($conn === null) {
  echo "Fallo en la conexión.";
  exit();
}

$query_productos = "
  SELECT
    p.Nombre AS NombreProducto,
    p.Descripcion AS DescripcionProducto,
    pp.Cantidad AS CantidadPedido,
    c.Nombre AS NombreCategoria
  FROM PedidoProducto pp
  JOIN Producto p ON pp.Producto = p.Codigo
  JOIN Categoria c ON p.Categoria = c.Codigo
  WHERE pp.Pedido = :id_pedido
";
$stmt_productos = $conn->prepare($query_productos);
$stmt_productos->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
$stmt_productos->execute();
$productos = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalles del Pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

  <main class="content flex-grow-1 m-4">
    <div class="container mt-4">
      <h1 class='text-center mb-4'>Productos del Pedido #<?php echo $id_pedido; ?></h1>

      <?php if (count($productos) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
          <?php foreach ($productos as $producto): ?>
            <div class="col">
              <div class="card shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title text-dark"><?php echo htmlspecialchars($producto['NombreProducto']); ?></h5>
                  <p class="card-subtitle mb-2 text-muted">Categoría: <?php echo htmlspecialchars($producto['NombreCategoria']); ?></p>
                  <p class="card-text text-dark">Descripción: <?php echo htmlspecialchars($producto['DescripcionProducto']); ?></p>
                  <p class="card-text text-dark">Cantidad pedida: <?php echo htmlspecialchars($producto['CantidadPedido']); ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="text-center mt-4">
          <a href="../cart/crearPDF.php?id=<?php echo $id_pedido; ?>" class="btn btn-primary">Exportar a PDF</a>
        </div>

      <?php else: ?>
        <p class="text-center text-muted mt-4">No hay productos asociados a este pedido.</p>
      <?php endif; ?>
    </div>
  </main>

  <footer class="container-fluid d-flex justify-content-center align-items-center pt-3 pb-3 shadow-sm text-white" style="background-color: #6a329f;">
    <a href="https://github.com/PinkBlure" class="text-white text-decoration-none">@PinkBlure</a>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
