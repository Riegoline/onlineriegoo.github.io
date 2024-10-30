-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2024 a las 22:07:16
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
-- Base de datos: `webfresas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `humedad`
--

CREATE TABLE `humedad` (
  `id_humedad` int(11) NOT NULL,
  `hum_int` varchar(10) NOT NULL,
  `hum_amb` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `humedad`
--

INSERT INTO `humedad` (`id_humedad`, `hum_int`, `hum_amb`) VALUES
(1, '89', '32'),
(2, '28', '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_registro`
--

CREATE TABLE `login_registro` (
  `id_Usuario` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contraseña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login_registro`
--

INSERT INTO `login_registro` (`id_Usuario`, `Usuario`, `Apellidos`, `Email`, `Contraseña`) VALUES
(1, 'Cristian', 'Velazquez', 'cris123@gmail.com', '1234'),
(2, 'JuanPerez', 'Pérez García', 'juan.perez@email.com', 'contraseña123'),
(3, 'MariaLopez', 'López Martínez', 'maria.lopez@email.com', 'clave456'),
(4, 'CarlosSanchez', 'Sánchez Rodríguez', 'carlos.sanchez@email.com', 'segura789');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temperatura`
--

CREATE TABLE `temperatura` (
  `id_temp` int(11) NOT NULL,
  `temperatura` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temperatura`
--

INSERT INTO `temperatura` (`id_temp`, `temperatura`) VALUES
(1, '26'),
(3, '25');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `humedad`
--
ALTER TABLE `humedad`
  ADD PRIMARY KEY (`id_humedad`);

--
-- Indices de la tabla `login_registro`
--
ALTER TABLE `login_registro`
  ADD PRIMARY KEY (`id_Usuario`);

--
-- Indices de la tabla `temperatura`
--
ALTER TABLE `temperatura`
  ADD PRIMARY KEY (`id_temp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `humedad`
--
ALTER TABLE `humedad`
  MODIFY `id_humedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `login_registro`
--
ALTER TABLE `login_registro`
  MODIFY `id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `temperatura`
--
ALTER TABLE `temperatura`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
