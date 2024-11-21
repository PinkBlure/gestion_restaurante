<?php
session_start();
session_destroy();
header("Location: /Proyectos/gestion_restaurante/index.php");
exit();
?>
