-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2017 a las 17:52:07
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `projectmanager`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_docente` int(10) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los administradores';

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_docente`, `estado`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'Activo', '2017-06-13', NULL),
(4, 'Activo', '2017-06-14', NULL),
(16, 'Activo', '2017-06-21', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(10) NOT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los cursos';

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id_curso`, `codigo`, `nombre`) VALUES
(1, '1150605', 'Analisis y diseno de sistemas'),
(2, '1150606', 'Seminario de investigacion II'),
(3, '11500704', 'Teoria General de las Comunicaciones'),
(4, '1150809', 'Formulacion y evaluacion de proyectos'),
(5, '1150705', 'Ingenieria de software'),
(6, '1150804', 'Redes de computadores'),
(7, '1150604', 'Sistemas operativos'),
(9, '1150817', 'Gestion de bases de datos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_docente`
--

CREATE TABLE `curso_docente` (
  `id_curso_docente` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `grupo` varchar(1) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  `periodo` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los docentes_cursos';

--
-- Volcado de datos para la tabla `curso_docente`
--

INSERT INTO `curso_docente` (`id_curso_docente`, `id_curso`, `id_docente`, `grupo`, `anio`, `periodo`) VALUES
(1, 1, 1, 'A', 2017, 1),
(2, 3, 4, 'A', 2017, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_estudiante`
--

CREATE TABLE `curso_estudiante` (
  `id_curso_estudiante` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL,
  `id_estudiante` int(10) NOT NULL,
  `grupo` varchar(1) NOT NULL,
  `anio` int(4) NOT NULL,
  `periodo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` int(10) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los docentes';

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `nombre`, `correo`, `telefono`, `contrasena`) VALUES
(1, 'Carlos Tapias', 'carlosalexistr@ufps.edu.co', '3213332323', '$2y$10$ska9rqTEaTzFi7fkQdBw9eNDP8keFIQ1LAzCioRZKSn74ciTOm.ki'),
(4, 'Brayam Mora', 'brayamalbertoma@ufps.edu.co', '3213342362', '$2y$10$/2yQIoPCDbMf4cB6p.wR3OlNM824ycMTj2Qkvdu0IUxNWSFvGShAK'),
(5, 'Julian Olarte', 'fredyjulianot@ufps.edu.co', '5755656', '$2y$10$m5WWiMfoMDIxotM8sZ/6uucnGYoSYn/1.1VYyIikhla8XPNVd14Q2'),
(14, 'Janeth Parada', 'janethpc@ufps.edu.co', '3243342333', '$2y$10$kzv289hlAsjSo.wQXCPCAOz3xghfLK3O.8BZhu9Lr.NukRJNqhk5C'),
(15, 'Martin Calixto', 'mcalixto@ufps.edu.co', '3155432213', '$2y$10$MKF4IBF3rQVWKSFFxzwAZu4KVeceo8bCYFiOO2sdirQJ1hrAM3ake'),
(16, 'Pilar Rodriguez', 'judithdelpilart@ufps.edu.co', '32111123232', '$2y$10$XEhgrr4s/d1YbtmCqXg3H.oIWlPXCLbaoYNcDF7FrewZj0cKhgyou');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int(10) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los estudiantes';

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `nombre`, `correo`, `telefono`, `contrasena`, `codigo`) VALUES
(12, 'Cristiano Ronaldo', 'cristianor@ufps.edu.co', '777776', '$2y$10$Llasxzy79dv3ZNPGiKmyQ.lIf0XtkOfF7WKYtgUkwC8xoWBG9IZIO', 1151010);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `id_proyecto` int(10) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_curso` int(10) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `url_app` varchar(200) DEFAULT NULL,
  `url_code` varchar(200) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `archivo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los proyectos';

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`id_proyecto`, `id_docente`, `id_curso`, `nombre`, `descripcion`, `url_app`, `url_code`, `fecha_inicio`, `fecha_fin`, `estado`, `archivo`) VALUES
(1, 1, 1, 'Gestor de proyectos', 'Sistema gestor de proyectos del programa ingenieria de sistemas', 'gestordeproyectos.ufps.edu.co', 'codigoproyecto.ufps.edu.co', '2017-06-15', NULL, 'En desarrollo', 'C:xampphtdocsprojectmanagercontrolador/../archivos/Taller4.pdf'),
(2, 4, 3, 'Proyecto de Cableado Estructurado', 'Realizado con el fin de plantear un diseÃ±o de cableado estructurado.', 'www.cableadoEstructurado.com', 'github.com/brayammora/cableadoEstructurado', '2017-06-21', NULL, 'En desarrollo', 'C:xampphtdocsprojectmanagercontrolador/../archivos/'),
(3, 4, 3, 'Proyecto 2', 'Proyecto numero 2 jeje', 'www.proy.com', 'github.com/brayammora/proy', '2017-06-21', NULL, 'En desarrollo', 'C:xampphtdocsprojectmanagercontrolador/../archivos/'),
(4, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_estudiante`
--

CREATE TABLE `proyecto_estudiante` (
  `id_proyecto_estudiante` int(10) NOT NULL,
  `id_proyecto` int(10) NOT NULL,
  `id_estudiante` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los proyectos_estudiantes';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_docente`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`);

--
-- Indices de la tabla `curso_docente`
--
ALTER TABLE `curso_docente`
  ADD PRIMARY KEY (`id_curso_docente`),
  ADD KEY `curso_docente_docente_fk` (`id_docente`),
  ADD KEY `curso_docente_curso_fk` (`id_curso`);

--
-- Indices de la tabla `curso_estudiante`
--
ALTER TABLE `curso_estudiante`
  ADD PRIMARY KEY (`id_curso_estudiante`),
  ADD KEY `curso_estudiante_curso_fk` (`id_curso`),
  ADD KEY `id_estudiante` (`id_estudiante`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id_docente`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `proyecto_docente_fk` (`id_docente`),
  ADD KEY `proyecto_curso_fk` (`id_curso`);

--
-- Indices de la tabla `proyecto_estudiante`
--
ALTER TABLE `proyecto_estudiante`
  ADD PRIMARY KEY (`id_proyecto_estudiante`),
  ADD KEY `proyecto_estudiante_proyecto_fk` (`id_proyecto`),
  ADD KEY `proyecto_estudiante_estudiante_fk` (`id_estudiante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `curso_docente`
--
ALTER TABLE `curso_docente`
  MODIFY `id_curso_docente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `curso_estudiante`
--
ALTER TABLE `curso_estudiante`
  MODIFY `id_curso_estudiante` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id_docente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `id_proyecto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proyecto_estudiante`
--
ALTER TABLE `proyecto_estudiante`
  MODIFY `id_proyecto_estudiante` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_pfk` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `curso_docente`
--
ALTER TABLE `curso_docente`
  ADD CONSTRAINT `curso_docente_curso_fk` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `curso_docente_docente_fk` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `curso_estudiante`
--
ALTER TABLE `curso_estudiante`
  ADD CONSTRAINT `curso_estudiante_curso_fk` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `curso_estudiante_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `proyect_curso_fk` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proyecto_docente_fk` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyecto_estudiante`
--
ALTER TABLE `proyecto_estudiante`
  ADD CONSTRAINT `proyecto_estudiante_estudiante_fk` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proyecto_estudiante_proyecto_fk` FOREIGN KEY (`id_proyecto`) REFERENCES `proyecto` (`id_proyecto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
