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

if (isset($_POST['codigoProducto'], $_POST['cantidad'])) {
  $codigoProducto = $_POST['codigoProducto'];
  $codigoCategoria = $_POST['codigoCategoria'];
  $cantidadSolicitada = (int)$_POST['cantidad'];

  if ($cantidadSolicitada <= 0) {
    echo "La cantidad solicitada no es válida.";
    exit();
  }

  $conn = createConnection();
  if ($conn === null) {
    echo "Fallo en la conexión.";
    exit();
  }

  $stmt = $conn->prepare("SELECT CantidadStock FROM Producto WHERE Codigo = :codigo");
  $stmt->bindParam(':codigo', $codigoProducto, PDO::PARAM_INT);
  $stmt->execute();
  $producto = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($producto) {
    $cantidadStock = $producto['CantidadStock'];

    if ($cantidadStock >= $cantidadSolicitada) {
      if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
      }

      if (isset($_SESSION['cart'][$codigoProducto])) {
        $totalCantidadEnCarrito = $_SESSION['cart'][$codigoProducto]['cantidad'] + $cantidadSolicitada;

        if ($totalCantidadEnCarrito <= $cantidadStock) {
          $_SESSION['cart'][$codigoProducto]['cantidad'] += $cantidadSolicitada;
        } else {
          echo "No hay suficiente stock disponible para agregar esa cantidad.";
          exit();
        }
      } else {
        $_SESSION['cart'][$codigoProducto] = [
          'codigo' => $codigoProducto,
          'cantidad' => $cantidadSolicitada
        ];
      }

      $nuevoStock = $cantidadStock - $cantidadSolicitada;
      $updateStmt = $conn->prepare("UPDATE Producto SET CantidadStock = :nuevoStock WHERE Codigo = :codigo");
      $updateStmt->bindParam(':nuevoStock', $nuevoStock, PDO::PARAM_INT);
      $updateStmt->bindParam(':codigo', $codigoProducto, PDO::PARAM_INT);
      $updateStmt->execute();

      header("Location: /Proyectos/gestion_restaurante/src/pages/productos.php?codigo=" . $codigoCategoria);
      exit();
    } else {
      echo "No hay suficiente stock para añadir al carrito.";
      exit();
    }
  } else {
    echo "Producto no encontrado.";
    exit();
  }
} else {
  echo "Error: No se ha recibido un código de producto o una cantidad.";
  exit();
}
