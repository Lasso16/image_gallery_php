-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-11-2025 a las 01:48:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cursophp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asociados`
--

CREATE TABLE `asociados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asociados`
--

INSERT INTO `asociados` (`id`, `nombre`, `logo`, `descripcion`) VALUES
(1, 'Partner 1', 'log1.jpg', 'Descripción del partner 1'),
(2, 'Partner 2', 'log2.jpg', 'Descripción del partner 2'),
(3, 'Partner 3', 'log3.jpg', 'Descripción del partner 3'),
(4, 'Partner 4', 'log1.jpg', 'Descripción del partner 4'),
(5, 'Partner 5', 'log2.jpg', 'Descripción del partner 5'),
(6, 'Partner 6', 'log3.jpg', 'Descripción del partner 6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `numImagenes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `numImagenes`) VALUES
(1, 'Categoria 1', 17),
(2, 'Categoria 2', 14),
(3, 'Categoria 3', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exposiciones`
--

CREATE TABLE `exposiciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `activa` tinyint(1) DEFAULT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria` int(11) NOT NULL DEFAULT 1,
  `numVisualizaciones` int(11) DEFAULT 0,
  `numLikes` int(11) DEFAULT 0,
  `numDownloads` int(11) DEFAULT 0,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `nombre`, `titulo`, `descripcion`, `categoria`, `numVisualizaciones`, `numLikes`, `numDownloads`, `idUsuario`) VALUES
(13, '1.jpg', 'Foto 1', 'descripción imagen 1', 1, 3245, 765, 2655, 3),
(14, '2.jpg', 'Foto 2', 'descripción imagen 2', 1, 85, 76, 26, 3),
(15, '3.jpg', 'Foto 3', 'descripción imagen 3', 1, 142, 567, 422, 3),
(16, '4.jpg', 'Foto 4', 'descripción imagen 4', 1, 106300, 57, 733, 3),
(17, '5.jpg', 'Foto 5', 'descripción imagen 5', 1, 1234, 76, 96, 3),
(18, '6.jpg', 'Foto 6', 'descripción imagen 6', 1, 976, 53, 100, 3),
(19, '7.jpg', 'Foto 7', 'descripción imagen 7', 1, 8764, 83, 568, 3),
(20, '8.jpg', 'Foto 8', 'descripción imagen 8', 1, 12, 36, 73, 3),
(21, '9.jpg', 'Foto 9', 'descripción imagen 9', 1, 235, 3456, 73, 3),
(22, '10.jpg', 'Foto 10', 'descripción imagen 10', 1, 525, 645, 1700, 3),
(23, '11.jpg', 'Foto 11', 'descripción imagen 11', 1, 472, 72, 26, 3),
(24, '12.jpg', 'Foto 12', 'descripción imagen 12', 1, 901, 8345, 325, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_exposicion`
--

CREATE TABLE `imagen_exposicion` (
  `id_imagen` int(11) NOT NULL,
  `id_exposicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `role`) VALUES
(3, 'admin', '$2y$10$AYWIt4HEmAn54M.ApRg9GehfQb0Lhut5odT9kqi.48X2.MeT/e0DW', 'ROLE_ADMIN'),
(4, 'user', '$2y$10$goNgehjCk1C/iiIex8OTi.SoV8DSqvksRpwHft4K0FGxMkrvOYcfC', 'ROLE_USER');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asociados`
--
ALTER TABLE `asociados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `exposiciones`
--
ALTER TABLE `exposiciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_exposiciones` (`idUsuario`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreignKey_categoria_imagenes` (`categoria`),
  ADD KEY `fk_imagen_usuario` (`idUsuario`);

--
-- Indices de la tabla `imagen_exposicion`
--
ALTER TABLE `imagen_exposicion`
  ADD PRIMARY KEY (`id_imagen`,`id_exposicion`),
  ADD KEY `imagenes_exposiciones_ibfk_2` (`id_exposicion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asociados`
--
ALTER TABLE `asociados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `exposiciones`
--
ALTER TABLE `exposiciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `exposiciones`
--
ALTER TABLE `exposiciones`
  ADD CONSTRAINT `fk_usuarios_exposiciones` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `fk_imagen_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreignKey_categoria_imagenes` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagen_exposicion`
--
ALTER TABLE `imagen_exposicion`
  ADD CONSTRAINT `imagen_exposicion_ibfk_1` FOREIGN KEY (`id_imagen`) REFERENCES `imagenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `imagen_exposicion_ibfk_2` FOREIGN KEY (`id_exposicion`) REFERENCES `exposiciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
