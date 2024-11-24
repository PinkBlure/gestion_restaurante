-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 25-11-2024 a las 00:51:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `gestionpedidos`
--
CREATE DATABASE IF NOT EXISTS `gestionpedidos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestionpedidos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categoria`
--
-- Creación: 21-11-2024 a las 21:14:22
--

DROP TABLE IF EXISTS `Categoria`;
CREATE TABLE IF NOT EXISTS `Categoria` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Categoria`
--

INSERT INTO `Categoria` (`Codigo`, `Nombre`, `Descripcion`) VALUES
(1, 'Entrantes', 'Platos pequeños para comenzar la comida'),
(2, 'Platos Principales', 'Comidas completas y sustanciosas'),
(3, 'Postres', 'Dulces y opciones para finalizar la comida'),
(4, 'Bebidas', 'Incluye refrescos, jugos y bebidas alcohólicas'),
(5, 'Ensaladas', 'Platos frescos y saludables con vegetales'),
(6, 'Sopas', 'Platos líquidos y reconfortantes para el inicio de la comida'),
(7, 'Pescados', 'Platos a base de pescado y mariscos'),
(8, 'Carnes', 'Platos a base de carne roja o blanca'),
(9, 'Pizza', 'Platos de pizza con una variedad de ingredientes'),
(10, 'Pastas', 'Platos a base de pasta con diferentes salsas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pedido`
--
-- Creación: 21-11-2024 a las 21:14:22
--

DROP TABLE IF EXISTS `Pedido`;
CREATE TABLE IF NOT EXISTS `Pedido` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `FechaPedido` date NOT NULL,
  `EstadoEnvio` tinyint(1) NOT NULL,
  `Restaurante` int(11) NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_restaurante` (`Restaurante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PedidoProducto`
--
-- Creación: 21-11-2024 a las 21:14:22
--

DROP TABLE IF EXISTS `PedidoProducto`;
CREATE TABLE IF NOT EXISTS `PedidoProducto` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Cantidad` int(11) NOT NULL,
  `Pedido` int(11) NOT NULL,
  `Producto` int(11) NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_pedido_producto` (`Pedido`),
  KEY `fk_producto_pedido` (`Producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Producto`
--
-- Creación: 21-11-2024 a las 21:14:22
-- Última actualización: 24-11-2024 a las 23:41:36
--

DROP TABLE IF EXISTS `Producto`;
CREATE TABLE IF NOT EXISTS `Producto` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text NOT NULL,
  `Peso` int(11) NOT NULL,
  `CantidadStock` int(11) NOT NULL,
  `Categoria` int(11) NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_categoria` (`Categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Producto`
--

INSERT INTO `Producto` (`Codigo`, `Nombre`, `Descripcion`, `Peso`, `CantidadStock`, `Categoria`) VALUES
(1, 'Ensalada Mixta', 'Ensalada fresca con tomate, lechuga y cebolla', 150, 22, 1),
(2, 'Sopa de Tomate', 'Sopa cremosa de tomate con albahaca', 200, 30, 1),
(3, 'Bruschetta', 'Pan tostado con tomate, albahaca y aceite de oliva', 100, 15, 1),
(4, 'Tartar de Atún', 'Tartar de atún fresco con aguacate', 120, 10, 1),
(5, 'Croquetas de Jamón', 'Croquetas rellenas de jamón serrano y bechamel', 50, 50, 1),
(6, 'Aceitunas Variadas', 'Aceitunas de diferentes tipos, servidas con aceite de oliva', 100, 25, 1),
(7, 'Ceviche de Pescado', 'Pescado fresco marinado con limón, cebolla y cilantro', 150, 10, 1),
(8, 'Pimientos de Padrón', 'Pimientos fritos con sal marina', 120, 30, 1),
(9, 'Tortilla Española', 'Tortilla de patatas con cebolla y huevo', 250, 20, 1),
(10, 'Hummus con Pan Pita', 'Hummus de garbanzo con pan pita', 200, 40, 1),
(11, 'Paella Valenciana', 'Paella tradicional con mariscos y arroz', 500, 10, 2),
(12, 'Hamburguesa de Ternera', 'Hamburguesa jugosa de carne de ternera con queso', 250, 20, 2),
(13, 'Lasaña Bolognesa', 'Lasaña con carne, salsa bolognesa y bechamel', 400, 15, 2),
(14, 'Pollo Asado', 'Pollo asado con papas y verduras', 350, 25, 2),
(15, 'Ravioli de Espinacas', 'Ravioli relleno de espinacas con salsa de tomate', 300, 30, 2),
(16, 'Arroz con Pollo', 'Arroz con pollo, zanahorias y guisantes', 350, 30, 2),
(17, 'Curry de Pollo', 'Pollo cocinado en una salsa cremosa de curry', 400, 15, 2),
(18, 'Bistec a la Parrilla', 'Bistec de res a la parrilla con papas fritas', 300, 20, 2),
(19, 'Pizza Margherita', 'Pizza con tomate, mozzarella y albahaca', 350, 50, 2),
(20, 'Salmón al Horno', 'Salmón fresco al horno con salsa de limón', 250, 15, 2),
(21, 'Tarta de Manzana', 'Tarta de manzana con masa quebrada y canela', 200, 30, 3),
(22, 'Brownie de Chocolate', 'Brownie de chocolate con nueces', 180, 25, 3),
(23, 'Helado de Vainilla', 'Helado cremoso de vainilla', 100, 40, 3),
(24, 'Mousse de Limón', 'Mousse suave y fresca de limón', 150, 35, 3),
(25, 'Flan Casero', 'Flan tradicional con caramelo', 120, 50, 3),
(26, 'Tiramisú', 'Postre italiano con café, cacao y mascarpone', 180, 20, 3),
(27, 'Galletas de Avena', 'Galletas de avena con pasas y miel', 80, 60, 3),
(28, 'Cheesecake de Frambuesa', 'Cheesecake con capa de frambuesa', 200, 15, 3),
(29, 'Panna Cotta', 'Panna cotta con coulis de frutas del bosque', 120, 40, 3),
(30, 'Pastel de Chocolate', 'Pastel de chocolate con cobertura de crema', 250, 30, 3),
(31, 'Cerveza Lager', 'Cerveza Lager fría', 330, 100, 4),
(32, 'Vino Tinto', 'Vino tinto seco de la región', 750, 50, 4),
(33, 'Refresco de Cola', 'Refresco de cola con burbujas', 500, 150, 4),
(34, 'Jugo de Naranja', 'Jugo fresco de naranja natural', 300, 80, 4),
(35, 'Agua Mineral', 'Agua mineral embotellada', 500, 200, 4),
(36, 'Café Espresso', 'Café espresso recién hecho', 100, 70, 4),
(37, 'Café con Leche', 'Café con leche caliente', 200, 60, 4),
(38, 'Mojito', 'Cóctel de ron, menta y lima', 250, 40, 4),
(39, 'Martini', 'Cóctel Martini con ginebra y vermut', 150, 30, 4),
(40, 'Te Helado', 'Te helado con limón', 350, 50, 4),
(41, 'Ensalada César', 'Ensalada con pollo, lechuga, crutones y aderezo César', 250, 30, 5),
(42, 'Ensalada Caprese', 'Tomate, mozzarella, albahaca y aceite de oliva', 200, 40, 5),
(43, 'Ensalada de Quinoa', 'Ensalada con quinoa, pepino, tomate y aguacate', 150, 35, 5),
(44, 'Ensalada Mediterránea', 'Ensalada con aceitunas, pepino, tomate y cebolla', 180, 45, 5),
(45, 'Ensalada de Frutas', 'Ensalada fresca con manzana, piña, fresas y uvas', 200, 50, 5),
(46, 'Ensalada de Pollo', 'Ensalada con pollo a la parrilla, lechuga y tomate', 250, 30, 5),
(47, 'Ensalada de Atún', 'Ensalada con atún, cebolla y pepino', 220, 25, 5),
(48, 'Ensalada de Garbanzos', 'Ensalada con garbanzos, tomate y pepino', 200, 40, 5),
(49, 'Ensalada de Aguacate', 'Ensalada con aguacate, tomate y cebolla morada', 180, 50, 5),
(50, 'Ensalada Vegana', 'Ensalada con vegetales frescos, aguacate y semillas', 250, 60, 5),
(51, 'Sopa de Lentejas', 'Sopa de lentejas con zanahorias y apio', 300, 42, 6),
(52, 'Sopa de Pollo', 'Sopa de pollo con fideos y zanahorias', 250, 50, 6),
(53, 'Sopa de Calabaza', 'Sopa cremosa de calabaza con especias', 200, 35, 6),
(54, 'Sopa de Mariscos', 'Sopa con mariscos y caldo de pescado', 250, 20, 6),
(55, 'Crema de Espárragos', 'Crema suave de espárragos', 180, 30, 6),
(56, 'Sopa de Acelga', 'Sopa de acelga con patatas y cebolla', 250, 40, 6),
(57, 'Sopa de Tomate', 'Sopa de tomate con albahaca y crutones', 200, 50, 6),
(58, 'Sopa de Champiñones', 'Sopa cremosa de champiñones', 220, 35, 6),
(59, 'Sopa Minestrone', 'Sopa italiana con verduras y pasta', 300, 25, 6),
(60, 'Sopa de Frijoles', 'Sopa espesa de frijoles con cebolla y ajo', 250, 40, 6),
(61, 'Filete de Salmón', 'Filete de salmón fresco a la parrilla', 200, 30, 7),
(62, 'Bacalao a la Vizcaína', 'Bacalao en salsa de tomate y pimientos', 250, 20, 7),
(63, 'Tartar de Salmón', 'Tartar de salmón con aguacate y cebollas moradas', 180, 25, 7),
(64, 'Atún a la Parrilla', 'Atún fresco a la parrilla con limón', 200, 30, 7),
(65, 'Pargo Frito', 'Pargo frito con papas y ensalada', 300, 15, 7),
(66, 'Lubina al Horno', 'Lubina horneada con hierbas aromáticas', 250, 25, 7),
(67, 'Ceviche de Pescado', 'Pescado marinado con cebolla, cilantro y limón', 150, 40, 7),
(68, 'Salmón Ahumado', 'Salmón ahumado con cebolla morada y alcaparras', 120, 50, 7),
(69, 'Pescado a la Veracruzana', 'Pescado con tomate, aceitunas y alcaparras', 250, 20, 7),
(70, 'Pez Espada a la Parrilla', 'Pez espada a la parrilla con salsa de hierbas', 200, 30, 7),
(71, 'Filete de Res', 'Filete de res a la parrilla con papas fritas', 300, 20, 8),
(72, 'Costillas a la Barbacoa', 'Costillas de cerdo con salsa barbacoa', 350, 25, 8),
(73, 'Pechuga de Pollo', 'Pechuga de pollo a la parrilla', 200, 30, 8),
(74, 'Entrecot', 'Entrecot de res a la parrilla con vegetales', 250, 15, 8),
(75, 'Pollo al Ajillo', 'Pollo al ajillo con arroz y ensalada', 300, 20, 8),
(76, 'Hamburguesa de Pollo', 'Hamburguesa de pollo con lechuga, tomate y mayonesa', 220, 35, 8),
(77, 'Churrasco', 'Carne de res a la parrilla con guarnición', 350, 20, 8),
(78, 'Albóndigas', 'Albóndigas de carne con salsa de tomate', 250, 30, 8),
(79, 'Pollo a la Naranja', 'Pollo con salsa de naranja y arroz', 280, 25, 8),
(80, 'Salchichas', 'Salchichas de cerdo a la parrilla', 200, 40, 8),
(81, 'Pizza Margarita', 'Pizza con salsa de tomate, mozzarella y albahaca', 350, 50, 9),
(82, 'Pizza Pepperoni', 'Pizza con salsa de tomate, mozzarella y pepperoni', 350, 40, 9),
(83, 'Pizza Hawaiana', 'Pizza con piña, jamón y mozzarella', 350, 30, 9),
(84, 'Pizza Vegetariana', 'Pizza con tomate, pimientos, aceitunas y champiñones', 350, 25, 9),
(85, 'Pizza Cuatro Quesos', 'Pizza con mozzarella, gouda, parmesano y roquefort', 350, 20, 9),
(86, 'Pizza de Pollo BBQ', 'Pizza con pollo, salsa barbacoa y cebolla roja', 350, 15, 9),
(87, 'Pizza Carbonara', 'Pizza con crema, bacon y huevo', 350, 10, 9),
(88, 'Pizza de Mariscos', 'Pizza con mariscos y salsa blanca', 350, 30, 9),
(89, 'Pizza de Ternera', 'Pizza con carne de ternera y cebolla caramelizada', 350, 20, 9),
(90, 'Pizza Calzone', 'Pizza rellena con carne, queso y salsa', 350, 25, 9),
(91, 'Spaghetti a la Boloñesa', 'Espaguetis con salsa bolognesa y carne molida', 350, 30, 10),
(92, 'Lasagna de Carne', 'Lasaña de carne con queso y salsa bechamel', 400, 25, 10),
(93, 'Ravioli de Ricotta', 'Ravioli relleno de ricotta con salsa de tomate', 300, 40, 10),
(94, 'Penne al Pesto', 'Penne con salsa pesto de albahaca y piñones', 250, 35, 10),
(95, 'Fettuccine Alfredo', 'Fettuccine con salsa Alfredo cremosa', 300, 20, 10),
(96, 'Tortellini de Jamón', 'Tortellini relleno de jamón y queso', 250, 30, 10),
(97, 'Pasta con Mariscos', 'Pasta con camarones, mejillones y calamares', 350, 15, 10),
(98, 'Macarrones con Queso', 'Macarrones con queso y crema', 200, 50, 10),
(99, 'Pasta Primavera', 'Pasta con verduras salteadas y salsa ligera', 250, 40, 10),
(100, 'Pasta Carbonara', 'Pasta con bacon y salsa carbonara cremosa', 300, 30, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Restaurante`
--
-- Creación: 21-11-2024 a las 21:14:22
--

DROP TABLE IF EXISTS `Restaurante`;
CREATE TABLE IF NOT EXISTS `Restaurante` (
  `Identificador` int(11) NOT NULL AUTO_INCREMENT,
  `Correo` varchar(100) NOT NULL,
  `Clave` varchar(10) NOT NULL,
  `Pais` enum('Afganistán','Albania','Argelia','Samoa Americana','Andorra','Angola','Anguilla','Antártida','Antigua y Barbuda','Argentina','Armenia','Aruba','Australia','Austria','Azerbaiyán','Bahamas','Baréin','Bangladesh','Barbados','Bielorrusia','Bélgica','Belice','Benín','Bermudas','Bután','Bolivia','Bosnia-Herzegovina','Botsuana','Brasil','Brunei Darussalam','Bulgaria','Burkina Faso','Burundi','Camboya','Camerún','Canadá','Cabo Verde','Islas Caimán','República Centroafricana','Chad','Chile','China','Isla de Navidad, Isla Christmas','Islas Cocos','Colombia','Comores','República Democrática del Congo','República del Congo','Islas Cook','Costa Rica','Costa de Marfil','Croacia','Cuba','Chipre','República Checa','Dinamarca','Djibouti, Yibuti','Dominica','República Dominicana','Ecuador','Egipto','El Salvador','Guinea Ecuatorial','Eritrea','Estonia','Etiopía','Islas Malvinas','Islas Feroe','Fiyi','Finlandia','Francia','Guayana Francesa','Polinesia Francesa','Gabón','Gambia','Georgia','Alemania','Ghana','Gibraltar','Grecia','Groenlandia','Granada','Guadalupe','Guam','Guatemala','Guinea','Guinea-Bisáu','Guyana','Haití','Honduras','Hong Kong','Hungría','Islandia','India','Indonesia','Irán','Iraq','Irlanda','Israel','Italia','Jamaica','Japón','Jordania','Kazajstán','Kenia','Kiribati','Corea del Norte','Corea del Sur','Kosovo','Kuwait','Kirguistán','Laos; oficialmente: República Democrática Popular Lao','Letonia','Líbano','Lesotho','Liberia','Libia','Liechtenstein','Lituania','Luxemburgo','Macao','Macedonia del Norte','Madagascar','Malawi','Malasia','Maldivas','Malí','Malta','Islas Marshall','Martinica','Mauritania','Mauricio','Mayotte','México','Micronesia, Estados Federados de','Moldavia','Mónaco','Mongolia','Montenegro','Montserrat','Marruecos','Mozambique','Myanmar, Birmania','Namibia','Nauru','Nepal','Países Bajos, Holanda','Antillas Holandesas','Nueva Caledonia','Nueva Zelanda','Nicaragua','Níger','Nigeria','Niue','Islas Marianas del Norte','Noruega','Omán','Pakistán','Palau','Palestina','Panamá','Papúa Nueva Guinea','Paraguay','Perú','Filipinas','Isla Pitcairn','Polonia','Portugal','Puerto Rico','Qatar','Reunión','Rumanía','Rusia','Ruanda','San Cristóbal y Nieves','Santa Lucía','San Vicente y las Granadinas','Samoa','San Marino','Santo Tomé y Príncipe','Arabia Saudita','Senegal','Serbia','Seychelles','Sierra Leona','Singapur','Eslovaquia','Eslovenia','Islas Salomón','Somalia','Sudáfrica','Sudán del Sur','España','Sri Lanka','Sudán','Surinam','Suazilandia, Esuatini','Suecia','Suiza','Siria','Taiwán (República de China)','Tayikistán','Tanzania','Tailandia','Tíbet','Timor Oriental','Togo','Tokelau','Tonga','Trinidad y Tobago','Túnez','Turquía','Turkmenistán','Islas Turcas y Caicos','Tuvalu','Uganda','Ucrania','Emiratos Árabes Unidos','Reino Unido','Estados Unidos','Uruguay','Uzbekistán','Vanuatu','Ciudad del Vaticano','Venezuela','Vietnam','Islas Virgenes Británicas','Islas Vírgenes de los Estados Unidos','Wallis y Futuna','Sáhara Occidental','Yemen','Zambia','Zimbabwe') NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `CodigoPostal` varchar(20) NOT NULL,
  PRIMARY KEY (`Identificador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
-- Creación: 21-11-2024 a las 21:14:55
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `codigo`) VALUES
(1, 'restaurante1@example.com', '81dc9bdb52d04dc20036dbd8313ed055', 'R001'),
(2, 'restaurante2@example.com', 'e2fc714c4727ee9395f324cd2e7f331f', 'R002');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Pedido`
--
ALTER TABLE `Pedido`
  ADD CONSTRAINT `fk_restaurante` FOREIGN KEY (`Restaurante`) REFERENCES `Restaurante` (`Identificador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `PedidoProducto`
--
ALTER TABLE `PedidoProducto`
  ADD CONSTRAINT `fk_pedido_producto` FOREIGN KEY (`Pedido`) REFERENCES `Pedido` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_pedido` FOREIGN KEY (`Producto`) REFERENCES `Producto` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Producto`
--
ALTER TABLE `Producto`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`Categoria`) REFERENCES `Categoria` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
