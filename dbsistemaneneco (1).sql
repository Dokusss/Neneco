-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2024 a las 05:13:07
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
-- Base de datos: `dbsistemaneneco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anticipos`
--

CREATE TABLE `anticipos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` decimal(17,2) NOT NULL,
  `idempleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anticipos`
--

INSERT INTO `anticipos` (`id`, `fecha`, `monto`, `idempleado`) VALUES
(1, '2024-04-16', 50.00, 101),
(2, '2024-04-17', 50.00, 102),
(3, '2024-05-10', 30.00, 103),
(4, '2024-05-10', 10.00, 105),
(5, '2024-05-10', 10.00, 109),
(6, '2024-05-11', 10.00, 108),
(7, '2024-05-11', 10.00, 109),
(8, '2024-05-11', 100.00, 110),
(9, '2024-05-13', 10.00, 104),
(10, '2024-05-13', 20.00, 113);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `entrada1` time NOT NULL,
  `salida1` time NOT NULL,
  `entrada2` time DEFAULT NULL,
  `salida2` time DEFAULT NULL,
  `horas` time NOT NULL,
  `horasextras` time NOT NULL,
  `retraso` time NOT NULL,
  `idempleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `sueldo` decimal(17,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `nombre`, `sueldo`) VALUES
(1, 'Gerente', 5000.00),
(2, 'Secretaria', 2400.00),
(3, 'Maestro carpintero', 2300.00),
(4, 'Maestro barnisador', 2300.00),
(5, 'Maestro barraca', 2300.00),
(6, 'Chofer', 2200.00),
(7, 'Ayudante carpinteria', 2100.00),
(8, 'Ayudante barnisador', 2100.00),
(9, 'Ayudante barraca', 2100.00),
(10, 'Ayudante chofer', 2100.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallehoraempleado`
--

CREATE TABLE `detallehoraempleado` (
  `idhorasextras` int(11) NOT NULL,
  `idempleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallehoraempleado`
--

INSERT INTO `detallehoraempleado` (`idhorasextras`, `idempleado`) VALUES
(1, 102),
(1, 106),
(1, 107);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `ci` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidop` varchar(50) NOT NULL,
  `apellidom` varchar(50) DEFAULT NULL,
  `genero` varchar(20) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `fechanac` date NOT NULL,
  `fechareg` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `idcargo` int(11) NOT NULL,
  `idhorario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `ci`, `nombre`, `apellidop`, `apellidom`, `genero`, `direccion`, `telefono`, `fechanac`, `fechareg`, `estado`, `idcargo`, `idhorario`) VALUES
(100, '9645626', 'Albert', 'Cardoza', 'Junin', 'masculino', 'Calle recaredo roda #541', '76619618', '1985-06-28', '2024-05-10', 1, 1, 1),
(101, '9645627', 'Rosmeri', 'Maldonado', NULL, 'femenino', 'Calle recaredo roda #5478', '76619619', '1990-12-28', '2024-05-10', 1, 2, 1),
(102, '9645628', 'Jose Carlos', 'Montero', 'Perez', 'masculino', 'Calle recaredo roda #541', '76619620', '1991-06-18', '2024-05-10', 1, 3, 1),
(103, '9645629', 'Pedro', 'Arias', 'Villa', 'masculino', 'Avenida melchor pinto #486', '76619621', '1989-10-08', '2024-05-10', 1, 4, 1),
(104, '9645631', 'Brandon', 'Rosales', 'Pedraza', 'masculino', 'Calle las palmeras #4621', '76619622', '1989-02-15', '2024-05-10', 1, 5, 1),
(105, '9645632', 'Carlos', 'Mole', 'Peredo', 'masculino', 'Calle salvatierra #486', '76619623', '1989-02-15', '2024-05-10', 1, 6, 1),
(106, '9645633', 'Mario', 'Ticona', 'Estrada', 'masculino', 'Avenida siempre viva #21', '76619624', '1989-02-15', '2024-05-10', 1, 7, 1),
(107, '9645634', 'Jose', 'Colque', 'Puma', 'masculino', 'Calle leandro gado #4781', '76619625', '1989-02-15', '2024-05-10', 1, 7, 1),
(108, '9645635', 'Kevin', 'Mamani', 'Quispe', 'masculino', 'Barrio el melgar #21', '76619626', '1989-02-15', '2024-05-10', 1, 8, 1),
(109, '9645636', 'Hector', 'Mamani', NULL, 'masculino', 'Avenida 24 de septembre #5451', '76619627', '2000-11-14', '2024-05-10', 1, 8, 1),
(110, '9645637', 'Manuel', 'Arias', 'Gonzales', 'masculino', 'Avenida 24 de septembre #58', '76619628', '1989-08-02', '2024-05-10', 1, 9, 1),
(111, '9645638', 'Roman', 'Villa', 'Trump', 'masculino', 'Barrio texacuz #581', '76619629', '1992-02-09', '2024-05-10', 1, 9, 1),
(112, '9645639', 'Juan', 'Montoya', 'Rivera', 'masculino', 'Avenida siempre viva #59', '76619630', '1981-12-30', '2024-05-10', 1, 10, 1),
(113, '9645640', 'Mario', 'Melgar', 'Romero', 'masculino', 'Calle los magales #102', '76619631', '1989-10-10', '2024-05-10', 1, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `entrada1` time NOT NULL,
  `salida1` time NOT NULL,
  `entrada2` time DEFAULT NULL,
  `salida2` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id`, `nombre`, `entrada1`, `salida1`, `entrada2`, `salida2`) VALUES
(1, 'normal', '08:00:00', '12:00:00', '14:00:00', '18:00:00'),
(2, 'noche', '18:00:00', '23:00:00', NULL, NULL),
(3, 'domingo', '08:00:00', '12:00:00', NULL, NULL),
(4, 'feriado', '08:00:00', '12:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horasextras`
--

CREATE TABLE `horasextras` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo` int(1) NOT NULL,
  `idhorario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horasextras`
--

INSERT INTO `horasextras` (`id`, `fecha`, `tipo`, `idhorario`) VALUES
(1, '0000-00-00', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechafin` date NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `motivo` text NOT NULL,
  `idempleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `fechainicio`, `fechafin`, `categoria`, `motivo`, `idempleado`) VALUES
(1, '2024-02-05', '2024-02-09', 'enfermedad', 'le dio dengue', 102),
(2, '2024-02-07', '2024-02-08', 'ocasional', 'teniar que tramitar su licencia', 109),
(3, '2024-02-14', '2024-05-07', 'maternidad', 'dio a luz', 101),
(4, '2024-03-01', '2024-03-09', 'compasivo', 'se murio su padre', 102),
(5, '2024-03-01', '2024-03-02', 'ocasional', 'problemas con el hijo en el colegio', 113),
(6, '2024-04-04', '2024-04-10', 'enfermedad', 'salmonela', 108),
(7, '2024-04-12', '2024-04-17', 'especial', 'permiso especial', 110),
(8, '2024-04-15', '2024-04-17', 'ocasional', 'tramitar documentos', 104),
(9, '2024-04-16', '2024-04-18', 'ocasional', 'tramitar documentos', 107),
(10, '2024-05-02', '2024-05-02', 'ocasional', 'tramitar documentos', 106);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planilla`
--

CREATE TABLE `planilla` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `horastrabajadas` varchar(10) NOT NULL,
  `diastrabajados` varchar(10) NOT NULL,
  `extras` decimal(17,2) DEFAULT NULL,
  `totalganado` decimal(17,2) NOT NULL,
  `descuentos` decimal(17,2) DEFAULT NULL,
  `totalfinal` decimal(17,2) NOT NULL,
  `idempleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `idempleado` int(11) NOT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `verificacion` varchar(20) NOT NULL,
  `evento` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `perfil` varchar(30) NOT NULL,
  `foto` text DEFAULT NULL,
  `ultimologin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anticipos`
--
ALTER TABLE `anticipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idempleado` (`idempleado`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idempleado` (`idempleado`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallehoraempleado`
--
ALTER TABLE `detallehoraempleado`
  ADD PRIMARY KEY (`idhorasextras`,`idempleado`),
  ADD KEY `idempleado` (`idempleado`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcargo` (`idcargo`),
  ADD KEY `idhorario` (`idhorario`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horasextras`
--
ALTER TABLE `horasextras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idhorario` (`idhorario`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idempleado` (`idempleado`);

--
-- Indices de la tabla `planilla`
--
ALTER TABLE `planilla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idempleado` (`idempleado`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idempleado` (`idempleado`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anticipos`
--
ALTER TABLE `anticipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2204;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `horasextras`
--
ALTER TABLE `horasextras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `planilla`
--
ALTER TABLE `planilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8165;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anticipos`
--
ALTER TABLE `anticipos`
  ADD CONSTRAINT `anticipos_ibfk_1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`id`);

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_2` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`id`);

--
-- Filtros para la tabla `detallehoraempleado`
--
ALTER TABLE `detallehoraempleado`
  ADD CONSTRAINT `detallehoraempleado_ibfk_1` FOREIGN KEY (`idhorasextras`) REFERENCES `horasextras` (`id`),
  ADD CONSTRAINT `detallehoraempleado_ibfk_2` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`id`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`idcargo`) REFERENCES `cargo` (`id`),
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`idhorario`) REFERENCES `horario` (`id`);

--
-- Filtros para la tabla `horasextras`
--
ALTER TABLE `horasextras`
  ADD CONSTRAINT `horasextras_ibfk_1` FOREIGN KEY (`idhorario`) REFERENCES `horario` (`id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`id`);

--
-- Filtros para la tabla `planilla`
--
ALTER TABLE `planilla`
  ADD CONSTRAINT `planilla_ibfk_1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`id`);

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
