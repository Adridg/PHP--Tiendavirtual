-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2017 a las 20:59:20
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP DATABASE IF EXISTS tiendavirtual_descansalandia;
CREATE DATABASE tiendavirtual_descansalandia;
USE tiendavirtual_descansalandia;
--
-- Base de datos: `tiendavirtual_descansalandia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE  IF NOT EXISTS `clientes` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` int(9) NOT NULL,
  `email` varchar(30) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `password` varchar(34) NOT NULL,
  `tipo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--
INSERT INTO `clientes` (`dni`, `nombre`, `direccion`, `telefono`, `email`, `usuario`, `password`, `tipo`) VALUES
('30256661F', 'Adrián', 'Puerto del Ocaso', 952159654, 'admin@gmail.es',  'admin', '$1$Ln3.2b1.$/q6GbJKt3h.HQDc24sJa4/', 'admin');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia`
--

CREATE TABLE IF NOT EXISTS `familia` (
  `cod` varchar(6) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `familia`
--

INSERT INTO `familia` (`cod`, `nombre`) VALUES
('coladu', 'Colchones de adultos'),
('colni', 'Colchones de niños'),
('cabece', 'Cabeceros'),
('sabana', 'Sabanas'),
('somi', 'Somieres fijos y articulados'),
('base', 'Bases y canapés para colchones'),
('almo', 'Almohadas');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE IF NOT EXISTS `fotos` (
  `num_ident` varchar(12) NOT NULL,
  `image_caption` varchar(200) NOT NULL,
  `image_username` varchar(200) NOT NULL,
  `image_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

CREATE TABLE IF NOT EXISTS `lineas` (
  `num_pedidos` int(4) NOT NULL,
  `num_linea` int(11) NOT NULL,
  `producto` varchar(12) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `cantidad` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE IF NOT EXISTS `marcas` (
  `id` int(4) NOT NULL,
  `nombre_marca` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `marcas` (`id`, `nombre_marca`) VALUES
(1, 'Pikolin'),
(2, 'Bultex'),
(3, 'Epeda'),
(4, 'Ipardo'),
(5, 'Tempur');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `num_pedidos` int(4) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `fecha` date NOT NULL,
  `totalPedidos` decimal(9,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `cod` varchar(12) NOT NULL,
  `nombre_corto` varchar(50) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `pvp` decimal(10,0) NOT NULL,
  `stock` int(3) NOT NULL,
  `familia` varchar(6) NOT NULL,
  `marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `productos` (`cod`, `nombre_corto`, `nombre`, `descripcion`, `pvp`, `stock`, `familia`, `marca`) VALUES
('colMile', 'milenium', 'Colchón milenium', 'La investigación al servicio del descanso más completo.', 1187, 5, 'coladu', 1),
('colPixel', 'pixel', 'Colchón Pixel', 'Un concepto innovador: descanso gradual + estabilidad personalizada.', 1187, 6, 'coladu', 2),
('colFocus', 'focus', 'Colchón Focus', 'Sumérgete en un descanso que te acoge y te mima.', 1158, 8, 'coladu', 3),
('colSuprem', 'suprem', 'Colchón Suprem', 'El descanso de lujo que ofrece adaptabilidad 5 estrellas.', 1032, 5, 'coladu', 4),
('colCori', 'corintio', 'Colchón Corintio', 'El descanso equilibrado.', 1008, 2, 'coladu', 5),
('colVin', 'vintage', 'Colchón Vintage', 'En busca de la perfección al dormir.', 1003, 10, 'coladu', 1),
('colZoom', 'zoom', 'Colchón Zoom Bultex', 'Colchón de Bultex con Memoryfoam.', 699, 7, 'coladu', 2),
('colDraco', 'draco', 'colchón Drago', 'Una decisión inteligente.', 410, 4, 'coladu', 4),
('colZoNi', 'zoomNiño', 'Colchón Zoom niños', 'Cuando la firmeza es la clave del descanso.', 870, 4, 'colni', 3),
('colDrNi', 'dracoNiño', 'Colchón Draco niños', 'La base estable que merece nuestro descanso.', 706, 6, 'colni', 4),
('colhd', 'hd', 'Colchón HD', 'Un descanso inteligente de gran relación calidad-precio.', 677, 7, 'colni', 5),
('colking', 'king', 'Colchón King', 'Haz de tu descanso tu reino.', 580, 8, 'colni', 2),
('coluli', 'ulises', 'Colchón Ulises', 'Un confort supremo a la altura de los dioses.', 575, 9, 'colni', 1),
('colcom', 'compas', 'Colchón Compás', 'El descanso que minimiza los movimientos al dormir.', 560, 10, 'colni', 3),
('colhur', 'huracan', 'Colchón Huracan', 'Perfecto para los más jóvenes de la casa.', 440, 12, 'colni', 2),
('coltor', 'tornado', 'Colchón Tornado', 'El descanso para los torbellinos de la casa: tus pequeños.', 300, 2, 'colni', 1),
('alcer', 'cervical', 'Almohada Visco Cervical', 'Su perfil cervical garantiza la máxima ergonomía durante el descanso, manteniendo la posición óptima del cuello y la cabeza.', 400, 15, 'almo', 1),
('alter', 'termal', 'Almohada Visco Termal', 'Su exclusivo tratamiento termorregulador, mantiene equilibrada la temperatura corporal durante toda la noche. Firmeza Media.', 750, 10, 'almo', 4),
('allatex', 'latex', 'Almohada Látex', 'El látex ofrece el equilibrio perfecto entre confort y firmeza y una alta comodidad cervical. Firmeza Media-Alta.', 800, 6, 'almo', 5),
('alaere', 'aerelle', 'Almohada New Aerelle', 'Máxima calidad en el descanso. Superresistente a lavados frecuentes. Firmeza Media.', 900, 10, 'almo', 3),
('alnoah', 'noah', 'Almohada NOAH PLUS', 'Almohada 100% con relleno de microfibra. Firmeza Media-Alta.', 560, 8, 'almo', 2),
('aliron', 'iron', 'Almohada Iron', 'Almohada de firmeza media-alta con tratamiento higiénico Sanitized® Silver Freshness que ofrece una protección natural contra ácaros, bacterias y hongos. Firmeza Media-Alta.', 350, 5, 'almo', 1),
('alpetit', 'petit', 'Almohada Petit Plus', 'Especialmente diseñada para niños. Firmeza Baja.', 360, 12, 'almo', 2),
('alpoli', 'polipluma', 'Almohada New Polipluma', 'Con doble funda y tratamiento higiénico contra ácaros, bacterias y hongos. Firmeza Media.', 650, 10, 'almo', 3),
('canaba3D', 'abatible3D', 'Canapés abatibles 3D', 'Creados y adaptados a las últimas tendencias en decoración, consiguiendo aportar un ambiente de modernidad y elegancia en el mobiliario para dormitorios.', 1400, 10, 'base', 3),
('bastapi', 'baseTranspirable', 'Bases transpirables', 'Base tapizada transpirable B.A.S.', 900, 15, 'base', 2),
('canmue', 'transpirable', 'Canapés de muelles tapizados transpirables', 'Base tapizada semirrígida con estructura flexible de muelles.', 1200, 6, 'base', 4),
('canaba', 'polipiel', 'Canapés abatibles de madera', 'Soporte ideal para cualquier tipo de colchones, se convierte en el armario horizontal de máxima capacidad que todo hogar necesita.', 1100, 7, 'base', 2),
('canjuv', 'naturbox', 'Abatible juvenil de apertura lateral', 'Base resistente que le ofrecerá un almacenaje extra, muy útil para habitaciones juveniles.', 1000, 8, 'base', 5),
('canpoli', 'abatible', 'Canapés abatibles polipiel 3D transpirables', 'Con un acabado de estética en polipiel de alto gramaje y resistencia permiten utilizar la parte inferior del colchón con una estética de diseño en dos colores a elegir: wengué y blanco.', 700, 6, 'base', 1),
('bastrans', 'tapizada', 'Bases tapizadas polipiel 3D transpirables', 'Base tapizada en polipiel transpirable ', 800, 4, 'base', 2),
('sosg16f', 'somierSG16F', 'Somier fijo SG16F', 'Guardaespaldas, láminas anchas de madera de máxima durabilidad y firmeza superior.', 1400, 9, 'somi', 3),
('sople', 'somierPlegable', 'Somier plegable', 'Somier Plegable con ruedas.', 1200, 8, 'somi', 2),
('sokit', 'somierDivanlin', 'Somier kit canguro Divanlin', 'Canguro Divanlín de máxima resistencia.', 1100, 13, 'somi', 4),
('sosg20', 'somierSG20', 'Somier fijo SG20', 'Guardaespaldas, máxima dispersión del calor.', 1250, 10, 'somi', 1),
('sosg20r', 'somierSG20R', 'Somier fijo SG20R', 'Guardaespaldas, adaptabilidad activa superior, gracias a sus 20 láminas de madera.', 1111, 16, 'somi', 2),
('sopack', 'somierFuturlam', 'Pack somier Futurlam y colchón Confortcel', 'Pack: Somier Futurlam metálico y Colchón Confortcel®.', 700, 14, 'somi', 5),
('soartmad', 'somierArtMadera', 'Somier ariculado eléctrico Futurlam madera', 'Somier con articulaciones eléctricas consiguiendo un total de 5 planos reales.', 650, 10, 'somi', 2),
('soartmet', 'somierArtMetal', 'Somier ariculado eléctrico Futurlam metálico', 'Somier eléctrico metálico articulado a motor con 5 planos de articulación.', 850, 15, 'somi', 4),
('cafre', 'franceso', 'Cabecero Francesco', 'La decoración de este cabecero Francesco en líneas irregulares y rodeado con un marco exterior le da un aire muy moderno.', 659, 20, 'cabece', 1),
('cagio', 'giordano', 'Cabecero Giordano', 'La decoración de este cabecero Giordano sólo en los extremos le confiere un aire muy elegante.Tejido El cabecero Giordan.', 400, 12, 'cabece', 3),
('cadel', 'delko', 'Cabecero Delko', 'El diseño en capitoné del cabecero Delko le dará una sensación de amplitud y luminosidad a la habitación.Tejido.', 350, 14, 'cabece', 2),
('cabia', 'biago', 'Cabecero Biagio', 'El cabecero Biagio tiene un bonito diseño. Se puede elegir diferentes colores para el cabecero y para las franjas verticales.', 700, 6, 'cabece', 4),
('cacoel', 'coel', 'Cabecero Coel', 'La combinación del capitoné con el marco cuadrado le otorga a este cabecero un toque clásico y elegante.', 650, 8, 'cabece', 5),
('casil', 'silvano', 'Cabecero Silvano', 'Este cabecero combina en su decoración el capitoné con un discreto patchwork dando como resultado un toque muy original.', 700, 6, 'cabece', 2),
('camun', 'mungo', 'Cabecero Mungo', 'Este cabecero combina en su decoración el capitoné con un original patchwork muy llamativo y colorido.', 650, 4, 'cabece', 1),
('capao', 'paolo', 'Cabecero Paolo', 'El acabado en capitoné y el diseño de este cabecero Paolo le confieren un aire muy elegante.', 500, 2, 'cabece', 2),
('sabento', 'encimeraTopos', 'Sábana Encimera Topos', 'Sabanas con bordados magníficos.', 17.15, 6, 'sabana', 5),
('sabennu', 'encimeraNude', 'Sábana Encimera Nude', 'Sabans vintage.', 45.50, 10, 'sabana', 2),
('sabenclook', 'encimeraLook', 'Sábana Encimera Look', 'Las sabanas de moda.', 29.95, 15, 'sabana', 3),
('sab3look', '3pizasLook', 'Juego Sábanas 3 Piezas Look', 'Elegante juegos de sabanas con finos bordados.', 30.15, 20, 'sabana', 1);


--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`dni`,`usuario`);

--
-- Indices de la tabla `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`num_ident`);

--
-- Indices de la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`num_linea`,`num_pedidos`),
  ADD KEY `lineas_ibfk_1` (`num_pedidos`),
  ADD KEY `lineas_ibfk_2` (`producto`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`num_pedidos`),
  ADD KEY `pedidos_ibfk_1` (`dni`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`cod`,`nombre_corto`),
  ADD KEY `productos_ibfk_1` (`familia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lineas`
--
ALTER TABLE `lineas`
  MODIFY `num_linea` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `num_pedidos` int(4) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`num_ident`) REFERENCES `productos` (`cod`);

--
-- Filtros para la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD CONSTRAINT `lineas_ibfk_1` FOREIGN KEY (`num_pedidos`) REFERENCES `pedidos` (`num_pedidos`),
  ADD CONSTRAINT `lineas_ibfk_2` FOREIGN KEY (`producto`) REFERENCES `productos` (`cod`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `clientes` (`dni`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`familia`) REFERENCES `familia` (`cod`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`marca`) REFERENCES `marcas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
