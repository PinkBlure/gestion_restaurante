<?php
session_start();
require_once "./src/db/database_functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['user'];
  $password = $_POST['passwd'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = [
      'email' => $user['email'],
      'code' => $user['user_code']
    ];
    $_SESSION['cart'] = [];
    header('Location: dashboard.php');
    exit();
  } else {
    $error = "Usuario o contraseña incorrectos.";
  }
}
