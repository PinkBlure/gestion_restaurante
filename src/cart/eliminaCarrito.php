<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Proyectos/gestion_restaurante/src/db/database_functions.php';

if (isset($_POST['codigoProducto']) && isset($_POST['cantidadEliminar'])) {
  $codigoProducto = $_POST['codigoProducto'];
  $cantidadEliminar = $_POST['cantidadEliminar'];

  if (!is_numeric($cantidadEliminar) || $cantidadEliminar <= 0) {
    header("Location: /Proyectos/gestion_restaurante/src/pages/carrito.php");
    exit();
  }

  $conn = createConnection();

  if ($conn === null) {
    echo "Fallo en la conexión.";
    exit();
  }

  if (isset($_SESSION['cart'][$codigoProducto])) {
    $cantidadEnCarrito = $_SESSION['cart'][$codigoProducto]['cantidad'];


    if ($cantidadEliminar > $cantidadEnCarrito) {
      header("Location: /Proyectos/gestion_restaurante/src/pages/carrito.php");
      exit();
    }

    $stmt = $conn->prepare("SELECT * FROM Producto WHERE Codigo = :codigo");
    $stmt->bindParam(':codigo', $codigoProducto, PDO::PARAM_INT);
    $stmt->execute();
    $productoDetalles = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($productoDetalles) {
      $cantidadStock = $productoDetalles['CantidadStock'];
      $nuevaCantidadStock = $cantidadStock + $cantidadEliminar;

      $stmtUpdate = $conn->prepare("UPDATE Producto SET CantidadStock = :cantidad WHERE Codigo = :codigo");
      $stmtUpdate->bindParam(':cantidad', $nuevaCantidadStock, PDO::PARAM_INT);
      $stmtUpdate->bindParam(':codigo', $codigoProducto, PDO::PARAM_INT);
      $stmtUpdate->execute();

      if ($cantidadEliminar == $cantidadEnCarrito) {
        unset($_SESSION['cart'][$codigoProducto]);
      } else {
        $_SESSION['cart'][$codigoProducto]['cantidad'] -= $cantidadEliminar;
      }

      header("Location: /Proyectos/gestion_restaurante/src/pages/carrito.php");
      exit();
    } else {
      header("Location: /Proyectos/gestion_restaurante/src/pages/carrito.php");
      exit();
    }
  } else {
    header("Location: /Proyectos/gestion_restaurante/src/pages/carrito.php");
    exit();
  }
}

header("Location: /Proyectos/gestion_restaurante/src/pages/carrito.php");
exit();
