-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220629.14f90d77f8
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-09-2022 a las 20:44:50
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario_sgei`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adquisidor`
--

CREATE TABLE `adquisidor` (
  `idadquisidor` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `adquisidor`
--

INSERT INTO `adquisidor` (`idadquisidor`, `nombre`, `telefono`, `direccion`) VALUES
(3, 'Liliana Maria Flores Lozano', '95464655', 'Dignidad'),
(4, 'Miguel Ángel Manco Balcázar', '946464112', 'Mala - Santa Rosa'),
(5, 'José Lévano Palomino', '955554521', 'Bujama Baja'),
(6, 'Riquelmer Amarildo Sandoval Peves', '958456666', 'San Antonio'),
(7, 'Carlos Sánchez Cardenas', '964646454', 'San Marcos de la Aguada'),
(8, 'Cesar Agusto Chumpitaz Camacho', '954645555', 'Asia'),
(9, 'Jaime Lostaunau Sánchez', '954644221', 'Asia'),
(10, 'Regulo E. Navarrete Paredes', '94646212', 'Cañete');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id` int(11) NOT NULL,
  `id_adquisidor` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `id_adquisidor`, `total`, `id_usuario`, `fecha`) VALUES
(1, 3, '139.65', 1, '2022-07-13 08:06:33'),
(2, 10, '3683.00', 1, '2022-07-13 08:13:55'),
(3, 6, '2665.00', 1, '2022-07-13 08:16:50'),
(4, 5, '415.80', 1, '2022-07-20 05:01:42'),
(5, 4, '3480.00', 1, '2022-07-20 05:30:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'Impresoras'),
(2, 'Monitores'),
(3, 'Parlantes'),
(4, 'Auriculares'),
(5, 'Laptop'),
(6, 'Computadora'),
(7, 'Teclado'),
(8, 'Mouse'),
(9, 'Camara'),
(10, 'Memoria'),
(11, 'Disco Duro'),
(12, 'Proyector'),
(13, 'Estabilizador'),
(14, 'Microfono'),
(15, 'Router'),
(16, 'Lector DVD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cargo`
--

CREATE TABLE `detalle_cargo` (
  `id` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `depreciacion` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monto` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_cargo`
--

INSERT INTO `detalle_cargo` (`id`, `id_material`, `id_cargo`, `cantidad`, `depreciacion`, `monto`, `total`) VALUES
(1, 8, 1, 1, '0.01', '35.00', '34.65'),
(2, 5, 1, 1, '0.00', '50.00', '50.00'),
(3, 6, 1, 1, '0.00', '55.00', '55.00'),
(4, 4, 2, 2, '0.00', '1000.00', '2000.00'),
(5, 7, 2, 1, '0.01', '1500.00', '1485.00'),
(6, 1, 2, 2, '0.01', '100.00', '198.00'),
(7, 6, 3, 3, '0.00', '55.00', '165.00'),
(8, 9, 3, 1, '0.00', '2500.00', '2500.00'),
(9, 12, 4, 1, '0.01', '180.00', '178.20'),
(10, 11, 4, 2, '0.01', '120.00', '237.60'),
(11, 9, 5, 1, '0.00', '2500.00', '2500.00'),
(12, 4, 5, 1, '0.02', '1000.00', '980.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_permisos`
--

CREATE TABLE `detalle_permisos` (
  `id` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `depreciacion` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monto_valor` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gerencias`
--

CREATE TABLE `gerencias` (
  `id` int(11) NOT NULL,
  `gerencias` varchar(100) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `id_org` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gerencias`
--

INSERT INTO `gerencias` (`id`, `gerencias`, `direccion`, `id_org`) VALUES
(1, 'Contabilidad', 'Piso1', 1),
(2, 'Recursos Humano', 'Piso 3', 1),
(3, 'Coactivo', 'Piso 2', 1),
(4, 'Desarrollo Humano', 'Piso 3', 1),
(5, 'Secretaria General', 'Piso 3', 1),
(6, 'Fiscalización', 'Piso 2', 1),
(7, 'Obras Privadas', 'Piso 3', 1),
(8, 'Logistica', 'Piso 4', 1),
(9, 'Sub Estadísticas e Informática', 'Piso 2', 1),
(10, 'Catastro', 'Piso 3', 1),
(11, 'Sub Riesgos y Desastres', 'Piso 3', 1),
(12, 'Desarrollo Empresarial', 'Piso 3', 1),
(13, 'Tesoreria', 'Piso 1', 1),
(14, 'Obras Publicas', 'Piso 2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nombre_corto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `nombre`, `nombre_corto`) VALUES
(1, 'HP', 'HP'),
(2, 'Dell', 'Dell'),
(3, 'Samsung', 'Samsung'),
(4, 'Asus', 'Asus'),
(5, 'Lenovo', 'Lenovo'),
(6, 'Microsoft', 'Microsoft'),
(7, 'Ebic', 'Ebic'),
(8, 'Teraware ', 'Teraware '),
(9, 'Logitech', 'Logitech'),
(10, 'Razer Kiyo Pro', 'RKP'),
(11, 'Kingston', 'Kingston'),
(12, 'LG', 'LG'),
(13, 'Philips', 'Philips'),
(14, 'Jetion', 'Jetion'),
(15, 'Cougar', 'Cougar'),
(16, 'Gygabyte', 'Gygabyte'),
(17, 'Micronics', 'Micronics'),
(18, 'Epson', 'Epson');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `codmateriales` int(11) NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `existencia` int(11) NOT NULL,
  `id_ger` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `fecha_actual` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`codmateriales`, `codigo`, `descripcion`, `valor`, `existencia`, `id_ger`, `id_marca`, `id_categoria`, `fecha_actual`) VALUES
(1, 'sgei0001', 'Tecl Mk200 bluetooth', '100.00', 18, 9, 9, 7, '2022-07-03'),
(2, 'sgei0002', 'HP omen I7 g10 500Gb SSD', '3500.00', 3, 9, 1, 5, '2022-07-01'),
(4, 'sgei0003', 'CPU i3 g5 GL1254', '1000.00', 8, 9, 16, 6, '2022-07-11'),
(5, 'sgei0004', 'WebCam L100 ', '50.00', 20, 9, 8, 9, '2022-07-04'),
(6, 'sgei0005', 'TT500 Mouse inalámbrico', '55.00', 20, 9, 9, 8, '2022-07-02'),
(7, 'sgei0006', 'Multiuso Epson 344', '1500.00', 19, 9, 18, 1, '2022-07-06'),
(8, 'sgei0010', 'Usb 32gb Nex', '35.00', 9, 9, 18, 1, '2022-07-07'),
(9, 'sgei0008', 'Brother Epson XL1000', '2500.00', 4, 9, 18, 1, '2022-07-07'),
(10, 'sgei0009', 'Usb 64gb Nex', '40.00', 8, 9, 11, 10, '2022-07-04'),
(11, 'sgei0011', 'Odyssey G5 de 20\"', '120.00', 10, 9, 3, 2, '2022-07-18'),
(12, 'sgei0012', 'Forza FVR-2202 8 Tomas', '180.00', 9, 9, 17, 13, '2022-07-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizacion`
--

CREATE TABLE `organizacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `organizacion`
--

INSERT INTO `organizacion` (`id`, `nombre`, `telefono`, `email`, `direccion`) VALUES
(1, 'Municipalidad Distrital de Mala', '997122350', 'sg.informatica@munimala.gob.pe', 'Plaza de Armas 177 Mala');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`) VALUES
(1, 'configuración'),
(2, 'usuarios'),
(3, 'adquisidor'),
(4, 'materiales'),
(5, 'cargos'),
(6, 'nuevo_cargo'),
(7, 'categorias'),
(8, 'marca'),
(9, 'gerencias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`) VALUES
(1, 'Sub Gerencia Sgei', 'sg.informatica@munimala.gob.pe', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'Maicol Rodriguez', '187090560@undc.edu.pe', 'maicol', '263bce650e68ab4e23f28263760b9fa5'),
(3, 'Fernando Michuy', 'sgei.user@munimala.gob.pe', 'fernando', 'e10adc3949ba59abbe56e057f20f883e'),
(4, 'Robert Paredes Huarcaya', 'sgei.admin@munimala.gob.pe', 'sgei', 'a4c5783bfd28cca690998df1c05b02b1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adquisidor`
--
ALTER TABLE `adquisidor`
  ADD PRIMARY KEY (`idadquisidor`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_adquisidor` (`id_adquisidor`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_cargo`
--
ALTER TABLE `detalle_cargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_material` (`id_material`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- Indices de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_permiso` (`id_permiso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_material` (`id_material`);

--
-- Indices de la tabla `gerencias`
--
ALTER TABLE `gerencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_org` (`id_org`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`codmateriales`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_ger` (`id_ger`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Indices de la tabla `organizacion`
--
ALTER TABLE `organizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adquisidor`
--
ALTER TABLE `adquisidor`
  MODIFY `idadquisidor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `detalle_cargo`
--
ALTER TABLE `detalle_cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `gerencias`
--
ALTER TABLE `gerencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `codmateriales` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `organizacion`
--
ALTER TABLE `organizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD CONSTRAINT `cargos_ibfk_1` FOREIGN KEY (`id_adquisidor`) REFERENCES `adquisidor` (`idadquisidor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cargos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_cargo`
--
ALTER TABLE `detalle_cargo`
  ADD CONSTRAINT `detalle_cargo_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`codmateriales`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_cargo_ibfk_2` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD CONSTRAINT `detalle_permisos_ibfk_1` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_permisos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`codmateriales`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gerencias`
--
ALTER TABLE `gerencias`
  ADD CONSTRAINT `gerencias_ibfk_1` FOREIGN KEY (`id_org`) REFERENCES `organizacion` (`id`);

--
-- Filtros para la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD CONSTRAINT `materiales_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `materiales_ibfk_2` FOREIGN KEY (`id_ger`) REFERENCES `gerencias` (`id`),
  ADD CONSTRAINT `materiales_ibfk_3` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



