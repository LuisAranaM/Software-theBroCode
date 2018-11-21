-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2018 a las 20:14:12
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `acme`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusr` int(11) NOT NULL,
  `codusr` char(30) NOT NULL,
  `passusr` char(30) NOT NULL,
  `nomusr` char(50) NOT NULL,
  `login` int(1) NOT NULL,
  `prod` int(1) NOT NULL,
  `finz` int(1) NOT NULL,
  `rrhh` int(1) NOT NULL,
  `ventas` int(1) NOT NULL,
  `scm` int(1) NOT NULL,
  `crm` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusr`, `codusr`, `passusr`, `nomusr`, `login`, `prod`, `finz`, `rrhh`, `ventas`, `scm`, `crm`) VALUES
(1, 'admin', '1234', 'Administrador', 1, 1, 1, 1, 1, 1, 1),
(2, 'jperez', '4444', 'Juan Perez', 0, 0, 0, 0, 1, 0, 0),
(3, 'mperez', '7777', 'Miguel PÃ©rez', 0, 0, 0, 0, 1, 0, 0),
(4, 'usuario1', '1234', 'Usuario Uno - modificado', 0, 0, 0, 0, 0, 0, 1),
(5, 'usuario02', '5555', 'Usuario 02 - modificado', 0, 1, 0, 0, 0, 0, 0),
(8, 'admin2', '4567', '1', 1, 1, 1, 1, 1, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusr`),
  ADD UNIQUE KEY `codusr` (`codusr`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
