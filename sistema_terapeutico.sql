-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-07-2025 a las 21:50:21
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
-- Base de datos: `sistema_terapeutico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acompanantes`
--

CREATE TABLE `acompanantes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `tipo_condicion` varchar(50) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `disponible` int(11) NOT NULL DEFAULT 1,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acompanantes`
--

INSERT INTO `acompanantes` (`id`, `usuario_id`, `dni`, `telefono`, `tipo_condicion`, `fecha_registro`, `disponible`, `activo`) VALUES
(1, 6, '324932203', '3414932932', 'TDAH', '2025-07-30 01:01:53', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nivel_acceso` tinyint(4) NOT NULL COMMENT '1=Basico, 2=Intermedio, 3=Superadmin',
  `departamento` varchar(50) DEFAULT NULL,
  `permisos_especiales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Permisos adicionales personalizados' CHECK (json_valid(`permisos_especiales`)),
  `firma_electronica` text DEFAULT NULL COMMENT 'Firma digital opcional'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_medico`
--

CREATE TABLE `historial_medico` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituciones`
--

CREATE TABLE `instituciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tipo` enum('educativa','sanitaria') NOT NULL,
  `sector` enum('publica','privada') NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instituciones`
--

INSERT INTO `instituciones` (`id`, `usuario_id`, `nombre`, `direccion`, `ciudad`, `provincia`, `telefono`, `email`, `tipo`, `sector`, `fecha_registro`, `activo`) VALUES
(1, 1, 'Jardín de Infantes Nº 101 “Los Pajaritos”', 'Calle 12 Nº 345', 'Rosario', 'Santa Fe', '+54 341 456 1234', 'jardin101@educacion.gob.ar', 'educativa', 'publica', '2025-07-27 18:15:21', 1),
(2, 0, 'Jardín Maternal “Pequeños Gigantes”', 'Av. San Martín 234', 'Santa Fe', 'Santa Fe', '+54 342 457 2345', 'pequenosgigantes@gmail.com', 'educativa', 'privada', '2025-07-27 18:15:21', 1),
(3, 0, 'Jardín de Infantes Nº 324 “Rayito de Sol”', 'Calle 1 Nº 234', 'Santa Fe', 'Santa Fe', '+54 342 456 1234', 'jardin324@educacion.gob.ar', 'educativa', 'publica', '2025-07-27 18:15:21', 1),
(4, 0, 'Jardín Maternal “Manitos Creativas”', 'Av. Francia 456', 'Rosario', 'Santa Fe', '+54 341 421 5678', 'maternal.creativas@gmail.com', 'educativa', 'privada', '2025-07-27 18:15:21', 1),
(5, 0, 'Escuela Primaria Nº 56 “General San Martín”', 'Calle 7 Nº 890', 'Rosario', 'Santa Fe', '+54 341 422 6789', 'ep56@educacion.gob.ar', 'educativa', 'publica', '2025-07-27 18:15:21', 1),
(6, 0, 'Escuela Primaria “Santa María”', 'Bv. Oroño 1234', 'Santa Fe', 'Santa Fe', '+54 342 456 7890', 'primariasantamaria@gmail.com', 'educativa', 'privada', '2025-07-27 18:15:21', 1),
(7, 0, 'Escuela Primaria Nº 2024 “General Belgrano”', 'Calle 10 Nº 567', 'Santa Fe', 'Santa Fe', '+54 342 455 9876', 'ep2024@educacion.gob.ar', 'educativa', 'publica', '2025-07-27 18:15:21', 1),
(8, 0, 'Escuela Primaria “San José”', 'Bv. Oroño 123', 'Rosario', 'Santa Fe', '+54 341 421 2345', 'escuela.sanjose@gmail.com', 'educativa', 'privada', '2025-07-27 18:15:21', 1),
(9, 0, 'Escuela Secundaria Nº 12 “Domingo Faustino Sarmiento”', 'Av. Pellegrini 567', 'Rosario', 'Santa Fe', '+54 341 423 4567', 'es12@educacion.gob.ar', 'educativa', 'publica', '2025-07-27 18:15:21', 1),
(10, 0, 'Instituto Secundario “San Rafael”', 'Calle 3 Nº 456', 'Santa Fe', 'Santa Fe', '+54 342 458 7654', 'institutosanrafael@gmail.com', 'educativa', 'privada', '2025-07-27 18:15:21', 1),
(11, 0, 'Escuela Secundaria Nº 502 “Domingo Faustino Sarmiento”', 'Calle 7 Nº 890', 'Santa Fe', 'Santa Fe', '+54 342 456 7890', 'es502@educacion.gob.ar', 'educativa', 'publica', '2025-07-27 18:15:21', 1),
(12, 0, 'Instituto Secundario “San Martín”', 'Av. Pellegrini 345', 'Rosario', 'Santa Fe', '+54 341 422 6789', 'instituto.sanmartin@gmail.com', 'educativa', 'privada', '2025-07-27 18:15:21', 1),
(13, 0, 'Escuela Especial Nº 5 “Nueva Esperanza”', 'Calle 20 Nº 678', 'Rosario', 'Santa Fe', '+54 341 429 8765', 'especial5@educacion.gob.ar', 'educativa', 'publica', '2025-07-27 18:15:21', 1),
(14, 0, 'Centro Educativo Especial “Horizontes”', 'Bv. Oroño 789', 'Santa Fe', 'Santa Fe', '+54 342 459 1234', 'horizontes@educacionprivada.com', 'educativa', 'privada', '2025-07-27 18:15:21', 1),
(15, 0, 'Escuela Especial Nº 101 “Nueva Esperanza”', 'Calle 15 Nº 432', 'Santa Fe', 'Santa Fe', '+54 342 457 0000', 'especial101@educacion.gob.ar', 'educativa', 'publica', '2025-07-27 18:15:21', 1),
(16, 0, 'Centro Educativo Especial “Horizontes”', 'Bv. Oroño 789', 'Rosario', 'Santa Fe', '+54 341 422 3456', 'horizontes@educacionprivada.com', 'educativa', 'privada', '2025-07-27 18:15:21', 1),
(17, 8, 'Jardin Inteligente 2931', 'Baigorria 9023', 'Rosario', 'Santa Fe', '389189824', 'Jardin-2515@gmail.com', 'educativa', 'publica', '2025-07-31 16:43:08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obras_sociales`
--

CREATE TABLE `obras_sociales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cuit` varchar(20) DEFAULT NULL,
  `ambito` enum('nacional','provincial','prepaga') DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `cobertura_terapeutas` tinyint(1) DEFAULT 1,
  `observaciones` text DEFAULT NULL,
  `activa` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `obras_sociales`
--

INSERT INTO `obras_sociales` (`id`, `nombre`, `cuit`, `ambito`, `direccion`, `ciudad`, `provincia`, `telefono`, `email`, `web`, `cobertura_terapeutas`, `observaciones`, `activa`) VALUES
(1, 'PAMI - Instituto Nacional de Servicios Sociales para Jubilados y Pensionados', '30-54667885-1', 'nacional', 'Av. Corrientes 655', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '138', 'info@pami.org.ar', 'https://www.pami.org.ar', 1, 'Cobertura total acompañantes terapéuticos para afiliados con discapacidad', 1),
(2, 'OSECAC - Obra Social de Empleados de Comercio', '30-52774544-1', 'nacional', 'Viamonte 870', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '+54 11 4324 0400', 'info@osecac.org.ar', 'https://osecac.org.ar', 1, 'Cobertura judicial para acompañantes terapéuticos', 1),
(3, 'OSPE - Obra Social de Petroleros', '30-68023431-9', 'nacional', 'Salta 264', 'Rosario', 'Santa Fe', '0800-222-6773', 'atencion@ospe.com.ar', 'https://www.ospe.com.ar', 1, 'Cobertura AT con autorización previa', 1),
(4, 'OSUTHGRA - Obra Social de Gastronómicos', '30-54687562-7', 'nacional', 'Azopardo 802', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0800-222-3947', 'consultas@osuthgra.org.ar', 'https://www.osuthgra.org.ar', 1, 'Cobertura AT con aprobación médica', 1),
(5, 'OSDE', '30-53026659-7', 'nacional', 'Av. Leandro N. Alem 1067', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-555-6733', 'info@osde.com.ar', 'https://www.osde.com.ar', 1, 'Plan 210 y superior cubren acompañantes terapéuticos', 1),
(6, 'OSDEPYM - Obra Social Empresarios, Profesionales y Monotributistas', '30-70702012-5', 'nacional', 'Moreno 1228', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-999-7788', 'info@osdepym.com.ar', 'https://www.osdepym.com.ar', 1, 'Cobertura AT previa autorización', 1),
(7, 'Swiss Medical', '30-63372558-9', 'prepaga', 'Av. Pueyrredón 1461', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-444-7700', 'contacto@swissmedical.com.ar', 'https://www.swissmedical.com.ar', 1, 'Planes superiores cubren acompañantes terapéuticos', 1),
(8, 'Galeno', '30-68547774-1', 'prepaga', 'Av. del Libertador 1035', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-222-3536', 'info@galeno.com.ar', 'https://www.galeno.com.ar', 1, 'Cobertura acompañantes según plan', 1),
(9, 'Medife', '30-68847220-6', 'prepaga', 'Av. Santa Fe 2121', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-666-6333', 'atencionalcliente@medife.com.ar', 'https://www.medife.com.ar', 1, 'Cobertura acompañantes terapéuticos en planes completos', 1),
(10, 'IAPOS - Instituto Autárquico Provincial de Obra Social', '30-60357789-4', 'provincial', 'San Martín 3145', 'Santa Fe', 'Santa Fe', '0800-444-4276', 'info@iapos.gov.ar', 'https://www.iapos.gov.ar', 1, 'Cobertura acompañantes terapéuticos con plan de trabajo aprobado', 1),
(11, 'OSPRERA - Obra Social del Personal Rural y Estibadores', '30-62597194-2', 'provincial', 'Mendoza 3425', 'Rosario', 'Santa Fe', '0341-438-3820', 'rosario@osprera.org.ar', 'https://www.osprera.org.ar', 1, 'Cobertura para discapacidad con acompañantes terapéuticos', 1),
(12, 'OSPE - Obra Social de Petroleros de Santa Fe', '30-68023431-9', 'provincial', 'Salta 264', 'Rosario', 'Santa Fe', '0800-222-6773', 'atencion@ospe.com.ar', 'https://www.ospe.com.ar', 1, 'Cobertura AT con autorización previa', 1),
(13, 'OBRA SOCIAL PROVINCIAL DE SANTA FE', '30-68276330-2', 'provincial', 'San Martín 3145', 'Santa Fe', 'Santa Fe', '0342-4521700', 'contacto@osp.sf.gov.ar', 'https://www.santafe.gob.ar', 1, 'Cobertura acompañantes terapéuticos para personas con discapacidad', 1),
(14, 'Medicus', '30-68456789-0', 'prepaga', 'Av. Santa Fe 1234', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-222-6336', 'info@medicus.com.ar', 'https://www.medicus.com.ar', 1, 'Planes superiores con cobertura de acompañantes terapéuticos', 1),
(15, 'OMINT', '30-68511223-1', 'prepaga', 'Av. del Libertador 7500', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-222-6666', 'atencion@omint.com.ar', 'https://www.omint.com.ar', 1, 'Cobertura acompañantes terapéuticos con autorización', 1),
(16, 'OSPEP - Obra Social del Personal de Empresas Petroleras', '30-68210987-5', 'nacional', 'Suipacha 654', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-333-6773', 'info@ospep.org.ar', 'https://www.ospep.org.ar', 1, 'Cobertura para acompañantes terapéuticos con plan aprobado', 1),
(17, 'OSFATUN - Obra Social de Trabajadores de Universidades Nacionales', '30-68211011-7', 'nacional', 'Perú 123', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-444-4400', 'info@osfatun.org.ar', 'https://www.osfatun.org.ar', 1, 'Cobertura AT aprobada', 1),
(18, 'OSPAT - Obra Social del Personal de Telecomunicaciones', '30-68211332-3', 'nacional', 'Córdoba 456', 'Ciudad Autónoma de Buenos Aires', 'Ciudad Autónoma de Buenos Aires', '0810-777-8100', 'info@ospat.org.ar', 'https://www.ospat.org.ar', 1, 'Cobertura para acompañantes terapéuticos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `fecha_de_nacimiento` datetime NOT NULL,
  `edad` int(11) NOT NULL,
  `direccion` text NOT NULL,
  `institucion_id` int(11) DEFAULT NULL,
  `tiene_obra_social` tinyint(1) NOT NULL DEFAULT 0,
  `obra_social_id` int(11) DEFAULT NULL,
  `acompanante_id` int(11) DEFAULT NULL,
  `tipo_condicion` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `numero_cud` varchar(50) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellido`, `usuario_id`, `dni`, `fecha_de_nacimiento`, `edad`, `direccion`, `institucion_id`, `tiene_obra_social`, `obra_social_id`, `acompanante_id`, `tipo_condicion`, `descripcion`, `numero_cud`, `fecha_registro`, `activo`) VALUES
(5, 'Lisandro', 'Chaui', 1, '43006738', '2000-10-30 00:00:00', 25, 'Jorge Fontana 2815', 1, 1, 10, 1, 'TDAH', 'Hola', '12345678', '2025-07-26 14:45:47', 1),
(8, 'Joaquin', 'Rodriguez', 1, '40120320', '2000-10-30 00:00:00', 24, 'Jorge Fontana 2815', 1, 1, 10, 1, 'TEA', 'Hola', '123456', '2025-07-28 20:10:09', 1),
(10, 'Leonardo', 'Martinez', 1, '12345678', '2000-02-20 00:00:00', 25, 'Jose lopez 2312', 17, 1, 10, 1, 'TDAH', 'Hola', '1234567', '2025-07-28 14:39:47', 1),
(11, 'Dimitrio', 'Martinez', 1, '03442442', '2000-02-20 00:00:00', 25, 'Jose lopez 2312', 17, 1, 10, 1, 'TDAH', 'Hola', '78910112', '2025-07-28 20:10:42', 1),
(13, 'Yamil', 'Martinez', 1, '9191919', '2000-02-20 00:00:00', 25, 'Jose lopez 2312', 17, 1, 10, 1, 'TEA', 'Hola', '919191919', '2025-07-28 20:10:42', 1),
(14, 'Bartolo', 'Martinez', 1, '8191919', '2000-02-20 00:00:00', 25, 'Jose lopez 2312', 17, 1, 10, 1, 'TDAH', 'Hola', '819191919', '2025-07-31 01:31:46', 1),
(15, 'Pablo', 'Gutierrez', 1, '93201030', '2000-02-01 00:00:00', 25, 'abc 123', 7, 1, 10, 1, 'TDAH', 'Hola', '93201030', '2025-07-28 20:10:42', 1),
(17, 'Diego', 'Argentino', 1, '73201030', '2000-02-01 00:00:00', 25, 'abc 123', 7, 1, 10, NULL, 'TDAH', 'Hola', '73201030', '2025-07-31 01:31:57', 1),
(18, 'Leando', 'Paredes', 4, '39128321', '2000-03-20 00:00:00', 25, 'Casa 234', 2, 1, 4, 1, 'TGD', 'Hola', '3132434', '2025-07-28 20:10:42', 1),
(19, 'Marlena', 'Facha', 5, '3423242', '2000-02-29 00:00:00', 25, 'cASA 3124', 17, 1, 4, 1, 'Parálisis_Cerebral', 'hOLA', '39942819', '2025-07-31 01:41:21', 1),
(20, 'Jaime', 'Baracusi', 7, '23040002', '2000-02-20 00:00:00', 25, 'Jose Luis 29004', 10, 0, NULL, 1, 'TDAH', 'Hola', '3231241', '2025-07-31 02:43:45', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `acompanante_id` int(11) DEFAULT NULL,
  `institucion_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(100) NOT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` varchar(10) NOT NULL,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_baja` datetime DEFAULT NULL,
  `rol_id` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Sin asignar, 2=Paciente, 3=Admin, 4=Acompañante, 5=Institución',
  `ultimo_acceso` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci KEY_BLOCK_SIZE=8 ROW_FORMAT=COMPRESSED;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `contrasena`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `fecha_alta`, `fecha_baja`, `rol_id`, `ultimo_acceso`, `activo`) VALUES
(1, 'lisandroadmin@gmail.com', '$2y$10$.mk30FSlz8zklNC9Jlz7oO1Dgd23najdRF9shP2nMySrlof9yethu', 'Lisandro Taiel', 'Chaui', '2000-10-30', 'masculino', '2025-07-22 19:39:59', NULL, 5, NULL, 1),
(2, 'Jacinadmin@gmail.com', '$2y$10$TEJxZA/GTpCQ1tgh7ENqPukRhiUgjZCiPwXBtto8b6RvzaIeWBUWa', 'Jacinto', 'Jasuela', '2000-10-30', 'masculino', '2025-07-22 19:48:56', NULL, 1, NULL, 1),
(3, 'falchias73@gmail.com', '$2y$10$gGaAAe06n82hwDooUVP.DudxpNMsqDXpwCemLbUeRAlC2PhD4LCCe', 'silvina', 'Falchi', '1973-05-24', 'femenino', '2025-07-22 20:07:48', NULL, 1, NULL, 1),
(4, 'Javo@gmail.com', '$2y$10$WPuJbPEYe.JS3Lv8qmdsA.8uS9f71KxzgWlEW8NpMMVGMp5.htOCm', 'javier', 'milei', '2000-10-24', 'masculino', '2025-07-24 17:40:01', NULL, 2, NULL, 1),
(5, 'M@gmail.com', '$2y$10$NU9SjRJSDcOYuXwpgm9kGeJFLA2Jf7XG6Khds7RFguCa3Hod15SnS', 'Marlene', 'Silvestre', '2000-02-29', 'femenino', '2025-07-24 18:30:03', NULL, 2, NULL, 1),
(6, 'lucia@gmail.com', '$2y$10$PlYEhxj9q1nXw7jueS.5I..ayLfAt2ocxF78ktLB9U6N7eq3cfX8m', 'Lucia', 'Galvan', '2000-02-25', 'femenino', '2025-07-25 15:27:08', NULL, 3, NULL, 1),
(7, 'Lima@gmail.com', '$2y$10$otNuRJeYvCQji3HOIuuOqudGmhbhjkB.uY3A3dKYQtquztV9psTpy', 'Lisandro', 'Tata', '2004-02-25', 'masculino', '2025-07-25 16:25:04', NULL, 2, NULL, 1),
(8, 'jaz@gmail.com', '$2y$10$oYVUi0vGDUORKxhDbWJGduCoP1VhdM252tyfTvFYYmmJ1zWBItnnS', 'Jazmin', 'Barracuso', '2000-10-20', 'femenino', '2025-07-26 15:16:02', NULL, 4, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acompanantes`
--
ALTER TABLE `acompanantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_acompanantes_dni` (`dni`),
  ADD KEY `idx_acompanantes_usuario` (`usuario_id`);

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`),
  ADD KEY `idx_nivel_acceso` (`nivel_acceso`);

--
-- Indices de la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_instituciones_nombre` (`nombre`);

--
-- Indices de la tabla `obras_sociales`
--
ALTER TABLE `obras_sociales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_pacientes_dni` (`dni`),
  ADD UNIQUE KEY `idx_pacientes_cud` (`numero_cud`),
  ADD KEY `idx_pacientes_usuario` (`usuario_id`),
  ADD KEY `idx_pacientes_institucion` (`institucion_id`),
  ADD KEY `idx_pacientes_condicion` (`tipo_condicion`(20)),
  ADD KEY `acompanante_id` (`acompanante_id`),
  ADD KEY `idx_pacientes_obra_social` (`obra_social_id`);
ALTER TABLE `pacientes` ADD FULLTEXT KEY `idx_pacientes_descripcion` (`descripcion`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `acompanante_id` (`acompanante_id`),
  ADD KEY `institucion_id` (`institucion_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_usuarios_email` (`email`),
  ADD KEY `idx_usuarios_rol_activo` (`rol_id`,`activo`),
  ADD KEY `idx_usuarios_nombre_apellido` (`nombre`,`apellido`),
  ADD KEY `idx_usuarios_acceso` (`ultimo_acceso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acompanantes`
--
ALTER TABLE `acompanantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `obras_sociales`
--
ALTER TABLE `obras_sociales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acompanantes`
--
ALTER TABLE `acompanantes`
  ADD CONSTRAINT `acompanantes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  ADD CONSTRAINT `historial_medico_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `fk_paciente_obra_social` FOREIGN KEY (`obra_social_id`) REFERENCES `obras_sociales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pacientes_ibfk_2` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pacientes_ibfk_3` FOREIGN KEY (`acompanante_id`) REFERENCES `acompanantes` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seguimiento_ibfk_2` FOREIGN KEY (`acompanante_id`) REFERENCES `acompanantes` (`id`),
  ADD CONSTRAINT `seguimiento_ibfk_3` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
