<?php
session_start();
require_once __DIR__ . '/../db/database_functions.php';

if (!isset($_SESSION['user'])) {
    header("Location: /Proyectos/gestion_restaurante/index.php");
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['pedido_message'] = 'El carrito está vacío. No se puede realizar el pedido.';
    header('Location: /Proyectos/gestion_restaurante/src/pages/carrito.php');
    exit();
}

$user = $_SESSION['user'];
$email_restaurante = $user['email'];
$cart = $_SESSION['cart'];

$conn = createConnection();
if ($conn === null) {
    $_SESSION['pedido_message'] = 'Error al conectar con la base de datos. Inténtelo de nuevo más tarde.';
    header('Location: /Proyectos/gestion_restaurante/src/pages/carrito.php');
    exit();
}

try {
    $query_restaurante = "SELECT Identificador FROM Restaurante WHERE Correo = :email";
    $stmt_restaurante = $conn->prepare($query_restaurante);
    $stmt_restaurante->bindParam(':email', $email_restaurante, PDO::PARAM_STR);
    $stmt_restaurante->execute();
    $restaurante = $stmt_restaurante->fetch(PDO::FETCH_ASSOC);

    if (!$restaurante) {
        $_SESSION['pedido_message'] = 'No se encontró el restaurante para el usuario autenticado.';
        header('Location: /Proyectos/gestion_restaurante/src/pages/carrito.php');
        exit();
    }

    $restaurante_codigo = $restaurante['Identificador'];

    $conn->beginTransaction();

    $query_pedido = "INSERT INTO Pedido (FechaPedido, EstadoEnvio, Restaurante)
                     VALUES (NOW(), 0, :restaurante_codigo)";
    $stmt_pedido = $conn->prepare($query_pedido);
    $stmt_pedido->bindParam(':restaurante_codigo', $restaurante_codigo, PDO::PARAM_INT);
    $stmt_pedido->execute();

    $pedido_id = $conn->lastInsertId();

    $query_producto = "INSERT INTO PedidoProducto (Cantidad, Pedido, Producto) VALUES (:cantidad, :pedido_id, :producto_codigo)";
    $stmt_producto = $conn->prepare($query_producto);

    foreach ($cart as $codigoProducto => $producto) {
        $stmt_producto->bindParam(':pedido_id', $pedido_id, PDO::PARAM_INT);
        $stmt_producto->bindParam(':producto_codigo', $codigoProducto, PDO::PARAM_INT);
        $stmt_producto->bindParam(':cantidad', $producto['cantidad'], PDO::PARAM_INT);
        $stmt_producto->execute();
    }

    $conn->commit();

    unset($_SESSION['cart']);

    $_SESSION['pedido_message'] = '¡Pedido realizado con éxito!';

    header('Location: /Proyectos/gestion_restaurante/src/pages/carrito.php');
    exit();

} catch (Exception $e) {
    $conn->rollBack();
    $_SESSION['pedido_message'] = 'Ocurrió un error al realizar el pedido: ' . $e->getMessage();
    header('Location: /Proyectos/gestion_restaurante/src/pages/carrito.php');
    exit();
}
?>
