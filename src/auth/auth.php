<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Proyectos/gestion_restaurante/src/db/database_functions.php';

$user = $_POST['user'] ?? '';
$passwd = $_POST['passwd'] ?? '';

if (empty($user) || empty($passwd)) {
  header("Location: /Proyectos/gestion_restaurante/index.php?error=1");
  exit();
}

try {
  $conn = createConnection();

  $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email AND password = MD5(:password)");
  $stmt->bindParam(':email', $user);
  $stmt->bindParam(':password', $passwd);
  $stmt->execute();
  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($usuario) {
    $_SESSION['user'] = [
      'email' => $usuario['email'],
      'codigo' => $usuario['codigo']
    ];

    if (isset($_COOKIE['cart'])) {
      $_SESSION['cart'] = json_decode($_COOKIE['cart'], true);
    } else {
      $_SESSION['cart'] = [];
    }

    header("Location: /Proyectos/gestion_restaurante/src/pages/lista.php");
    exit();
  } else {
    header("Location: /Proyectos/gestion_restaurante/index.php?error=1");
    exit();
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  exit();
}
