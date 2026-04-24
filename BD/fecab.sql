-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2026 a las 15:43:05
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
-- Base de datos: `fecab`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_emprendedor`
--

CREATE TABLE `registro_emprendedor` (
  `id` int(11) NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `tipo_id` varchar(20) NOT NULL,
  `numero_id` varchar(30) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `nacionalidad` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `clasificacion` varchar(100) DEFAULT NULL,
  `discapacidad` varchar(50) DEFAULT NULL,
  `tipo_emprendedor` varchar(50) DEFAULT NULL,
  `nivel_formacion` varchar(50) DEFAULT NULL,
  `ficha` varchar(50) DEFAULT NULL,
  `carrera` varchar(150) DEFAULT NULL,
  `programa` varchar(150) DEFAULT NULL,
  `situacion_negocio` varchar(150) DEFAULT NULL,
  `centro_orientacion` varchar(150) DEFAULT NULL,
  `orientador` varchar(100) DEFAULT NULL,
  `orientador_id` int(11) DEFAULT NULL,
  `pais_origen` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `rol` varchar(50) DEFAULT 'emprendedor',
  `contrasena` varchar(255) NOT NULL,
  `estado_proceso` varchar(20) DEFAULT 'activo',
  `ejercer_actividad_proyecto` enum('SI','NO') DEFAULT 'NO',
  `empresa_formalizada` enum('SI','NO') DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `registro_emprendedor`
--
ALTER TABLE `registro_emprendedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_id` (`numero_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `registro_emprendedor`
--
ALTER TABLE `registro_emprendedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
