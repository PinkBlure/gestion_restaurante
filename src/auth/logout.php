<?php
session_start();
setcookie('cart', json_encode($_SESSION['cart']), time() + (86400 * 30), "/");
session_destroy();
header("Location: /Proyectos/gestion_restaurante/index.php");
exit();
?>
