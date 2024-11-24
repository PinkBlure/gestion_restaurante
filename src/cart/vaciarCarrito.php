<?php
session_start();

if (isset($_SESSION['cart'])) {
  unset($_SESSION['cart']);
}

header("Location: /Proyectos/gestion_restaurante/src/pages/carrito.php");
exit();
