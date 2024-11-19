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

/* Funciones base para la tabla Categoria */
function insertarCategoria($nombre, $descripcion, $conn)
{
  try {
    $sql = "INSERT INTO Categoria (Nombre, Descripcion) VALUES (:nombre, :descripcion)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al insertar categoría: " .
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

function eliminarCategoria($codigo, $conn)
{
  try {
    $sql = "DELETE FROM Categoria WHERE Codigo = :codigo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al eliminar categoría: " .
      $ex->getMessage());
    return null;
  }
}

/* Funciones base para la tabla Pedido */
function insertarPedido($fechaPedido, $estadoEnvio, $restaurante, $conn)
{
  try {
    $sql = "INSERT INTO Pedido (FechaPedido, EstadoEnvio, Restaurante) VALUES (:fechaPedido, :estadoEnvio, :restaurante)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fechaPedido', $fechaPedido);
    $stmt->bindParam(':estadoEnvio', $estadoEnvio);
    $stmt->bindParam(':restaurante', $restaurante);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al insertar pedido: " .
      $ex->getMessage());
    return null;
  }
}

function seleccionarPedidos($conn)
{
  try {
    $sql = "SELECT * FROM Pedido";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $ex) {
    error_log("Error al seleccionar pedidos: " .
      $ex->getMessage());
    return null;
  }
}

function eliminarPedido($codigo, $conn)
{
  try {
    $sql = "DELETE FROM Pedido WHERE Codigo = :codigo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al eliminar pedido: " .
      $ex->getMessage());
    return null;
  }
}

/* Funciones base para la tabla PedidoProducto */
function insertarPedidoProducto($cantidad, $pedido, $producto, $conn)
{
  try {
    $sql = "INSERT INTO PedidoProducto (Cantidad, Pedido, Producto) VALUES (:cantidad, :pedido, :producto)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':pedido', $pedido);
    $stmt->bindParam(':producto', $producto);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al insertar pedido-producto: " .
      $ex->getMessage());
    return null;
  }
}

function seleccionarPedidoProductos($conn)
{
  try {
    $sql = "SELECT * FROM PedidoProducto";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $ex) {
    error_log("Error al seleccionar pedido-productos: " .
      $ex->getMessage());
    return null;
  }
}

function eliminarPedidoProducto($codigo, $conn)
{
  try {
    $sql = "DELETE FROM PedidoProducto WHERE Codigo = :codigo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al eliminar pedido-producto: " .
      $ex->getMessage());
    return null;
  }
}

/* Funciones base para la tabla Producto */
function insertarProducto($nombre, $descripcion, $peso, $cantidadStock, $categoria, $conn)
{
  try {
    $sql = "INSERT INTO Producto (Nombre, Descripcion, Peso, CantidadStock, Categoria) VALUES (:nombre, :descripcion, :peso, :cantidadStock, :categoria)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':peso', $peso);
    $stmt->bindParam(':cantidadStock', $cantidadStock);
    $stmt->bindParam(':categoria', $categoria);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al insertar producto: " .
      $ex->getMessage());
    return null;
  }
}

function seleccionarProductos($conn)
{
  try {
    $sql = "SELECT * FROM Producto";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $ex) {
    error_log("Error al seleccionar productos: " .
      $ex->getMessage());
    return null;
  }
}

function eliminarProducto($codigo, $conn)
{
  try {
    $sql = "DELETE FROM Producto WHERE Codigo = :codigo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al eliminar producto: " .
      $ex->getMessage());
    return null;
  }
}

/* Funciones base para la tabla Restaurante */
function insertarRestaurante($correo, $clave, $pais, $direccion, $codigoPostal, $conn)
{
  try {
    $sql = "INSERT INTO Restaurante (Correo, Clave, Pais, Direccion, CodigoPostal) VALUES (:correo, :clave, :pais, :direccion, :codigoPostal)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':clave', $clave);
    $stmt->bindParam(':pais', $pais);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':codigoPostal', $codigoPostal);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al insertar restaurante: " .
      $ex->getMessage());
    return null;
  }
}

function seleccionarRestaurantes($conn)
{
  try {
    $sql = "SELECT * FROM Restaurante";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $ex) {
    error_log("Error al seleccionar restaurantes: " .
      $ex->getMessage());
    return null;
  }
}

function eliminarRestaurante($identificador, $conn)
{
  try {
    $sql = "DELETE FROM Restaurante WHERE Identificador = :identificador";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':identificador', $identificador);
    return $stmt->execute();
  } catch (PDOException $ex) {
    error_log("Error al eliminar restaurante: " .
      $ex->getMessage());
    return null;
  }
}
