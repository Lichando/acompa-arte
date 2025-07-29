-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-07-2025 a las 00:52:45
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
  `parentesco` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `instituciones`
--

CREATE TABLE `instituciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activa` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obras_sociales`
--

CREATE TABLE `obras_sociales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activa` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `direccion` text NOT NULL,
  `institucion_id` int(11) DEFAULT NULL,
  `tiene_obra_social` tinyint(1) DEFAULT 0,
  `obra_social` varchar(100) DEFAULT NULL,
  `obra_social_id` int(11) DEFAULT NULL,
  `acompanante_id` int(11) DEFAULT NULL,
  `tipo_condicion` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `numero_cud` varchar(50) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

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
(1, 'lisandroadmin@gmail.com', '$2y$10$.mk30FSlz8zklNC9Jlz7oO1Dgd23najdRF9shP2nMySrlof9yethu', 'Lisandro Taiel', 'Chaui', '2000-10-30', '0', '2025-07-22 19:39:59', NULL, 1, NULL, 1),
(2, 'Jacinadmin@gmail.com', '$2y$10$TEJxZA/GTpCQ1tgh7ENqPukRhiUgjZCiPwXBtto8b6RvzaIeWBUWa', 'Jacinto', 'Jasuela', '2000-10-30', '0', '2025-07-22 19:48:56', NULL, 1, NULL, 1);

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
-- Indices de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_instituciones_nombre` (`nombre`);

--
-- Indices de la tabla `obras_sociales`
--
ALTER TABLE `obras_sociales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_obras_sociales_codigo` (`codigo`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `obras_sociales`
--
ALTER TABLE `obras_sociales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `fk_paciente_obra_social` FOREIGN KEY (`obra_social_id`) REFERENCES `obras_sociales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pacientes_ibfk_2` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pacientes_ibfk_3` FOREIGN KEY (`acompanante_id`) REFERENCES `acompanantes` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
