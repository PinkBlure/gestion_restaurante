<?php
session_start();

require_once __DIR__ . '/../db/database_functions.php';
require_once './pdf.php';

if (!isset($_SESSION['user'])) {
  header("Location: /Proyectos/gestion_restaurante/index.php");
  exit();
}

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

if (count($productos) === 0) {
  echo "No se encontraron productos para este pedido.";
  exit();
}

$titulo = "Detalles del Pedido #" . $id_pedido;
$contenido = "Productos del pedido:\n\n";

foreach ($productos as $producto) {
  $contenido .= "Nombre: " . htmlspecialchars($producto['NombreProducto']) . "\n";
  $contenido .= "Categoria: " . htmlspecialchars($producto['NombreCategoria']) . "\n";
  $contenido .= "Descripcion: " . htmlspecialchars($producto['DescripcionProducto']) . "\n";
  $contenido .= "Cantidad pedida: " . htmlspecialchars($producto['CantidadPedido']) . "\n";
  $contenido .= "-------------------------\n";
}

$pdf = new MiFPDF($titulo, $contenido, "Arial", 12, "L");
$pdf->generaDoc();
$pdf->devuelveDoc();
?>
