<?php

function enableErrorLog()
{
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  return true;
}

function createConnection()
{
  try {
    $host = "localhost";
    $db = "gestionpedidos";
    $user = "root";
    $pass = "";
    $dns = "mysql:host=$host;dbname=$db";
    $conn = new PDO($dns, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch (PDOException $ex) {
    error_log("Error en la conexión a la base de datos: " .
      $ex->getMessage());
    return null;
  }
}

function seleccionarCategorias($conn)
{
  try {
    $sql = "SELECT * FROM Categoria";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $ex) {
    error_log("Error al seleccionar categorías: " .
      $ex->getMessage());
    return null;
  }
}

function seleccionarProductos($conn, $codigoCategoria)
{
  try {
    $sql = "SELECT * FROM Producto WHERE Categoria = :codigoCategoria";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigoCategoria', $codigoCategoria, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $ex) {
    error_log("Error al seleccionar productos: " . $ex->getMessage());
    return null;
  }
}
