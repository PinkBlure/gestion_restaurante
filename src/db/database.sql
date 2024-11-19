-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-11-2024 a las 13:12:50
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
-- Creación: 19-11-2024 a las 12:03:59
--

DROP TABLE IF EXISTS `Categoria`;
CREATE TABLE IF NOT EXISTS `Categoria` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `Categoria`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pedido`
--
-- Creación: 19-11-2024 a las 12:03:16
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

--
-- RELACIONES PARA LA TABLA `Pedido`:
--   `Restaurante`
--       `Restaurante` -> `Identificador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PedidoProducto`
--
-- Creación: 19-11-2024 a las 12:06:56
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

--
-- RELACIONES PARA LA TABLA `PedidoProducto`:
--   `Pedido`
--       `Pedido` -> `Codigo`
--   `Producto`
--       `Producto` -> `Codigo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Producto`
--
-- Creación: 19-11-2024 a las 12:05:26
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `Producto`:
--   `Categoria`
--       `Categoria` -> `Codigo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Restaurante`
--
-- Creación: 19-11-2024 a las 12:01:05
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

--
-- RELACIONES PARA LA TABLA `Restaurante`:
--

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
