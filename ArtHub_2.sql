-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 06-12-2023 a las 17:45:20
-- Versión del servidor: 8.1.0
-- Versión de PHP: 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ArtHub`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artes`
--

CREATE TABLE `artes` (
  `CodArte` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `tipoDeArte` varchar(255) NOT NULL,
  `descripcion` varchar(555) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `foto` varchar(255) NOT NULL,
  `likes` int DEFAULT '0',
  `FechaCreacion` date DEFAULT NULL,
  `ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `artes`
--

INSERT INTO `artes` (`CodArte`, `titulo`, `tipoDeArte`, `descripcion`, `foto`, `likes`, `FechaCreacion`, `ID`) VALUES
(1, 'Titulo 1', 'TipoDeArte1', 'Descripcion1', 'https://media.admagazine.com/photos/618a6acacc7069ed5077ca7c/3:2/w_2250,h_1500,c_limit/69052.jpg', 12, '2022-12-12', 1),
(3, 'sdada', 'awdawd', 'descripciongeneralasdedosfifsifseiksdapdkeadaedadaadeadaeda', 'https://historia.nationalgeographic.com.es/medio/2023/09/27/01-mona-lisa-marco-gioconda-louvre_00000000_2d7f91a1_230927115301_550x807.jpg', 23, '2023-04-12', 1),
(17, 'Las meninas', 'Retrato', 'Las meninas o La familia de Felipe IV se considera la obra maestra del pintor del Siglo de Oro español Diego Velázquez. Acabado en 1656, según Antonio Palomino, fecha unánimemente aceptada por la crítica, corresponde al último periodo estilístico del artista, el de plena madurez.', 'https://content3.cdnprado.net/imagenes/Documentos/imgsem/9f/9fdc/9fdc7800-9ade-48b0-ab8b-edee94ea877f/41866afd-6396-45e7-bd26-944263cf92f7.jpg', 0, '2023-12-04', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `CodEmpresa` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`CodEmpresa`, `nombre`, `localidad`) VALUES
(1, 'Camper', 'Inca'),
(2, 'UniSpace', 'Madrid');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pais` varchar(255) NOT NULL,
  `profesion` varchar(255) NOT NULL,
  `CodEmpresa` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `nombre`, `apellidos`, `email`, `password`, `pais`, `profesion`, `CodEmpresa`) VALUES
(1, 'a', 'a', 'a@a', '0cc175b9c0f1b6a831c399e269772661', 'Spain', 'dibujante', 1),
(2, 'Juan', 'Flores ', 'W@W', '61e9c06ea9a85a5088a499df6458d276', 'Spain', 'dibujante', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artes`
--
ALTER TABLE `artes`
  ADD PRIMARY KEY (`CodArte`),
  ADD KEY `ID` (`ID`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`CodEmpresa`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CodEmpresa` (`CodEmpresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `artes`
--
ALTER TABLE `artes`
  MODIFY `CodArte` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `CodEmpresa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `artes`
--
ALTER TABLE `artes`
  ADD CONSTRAINT `artes_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`CodEmpresa`) REFERENCES `empresa` (`CodEmpresa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
