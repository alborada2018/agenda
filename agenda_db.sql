
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE `agenda_db`;


CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(127) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `fecha_finalizacion` date DEFAULT NULL,
  `hora_finalizacion` time DEFAULT NULL,
  `dia_completo` tinyint(1) NOT NULL,
  `fk_usuario` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `usuarios` (
  `email` varchar(127) NOT NULL,
  `nombre` varchar(127) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evento_usuario` (`fk_usuario`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`email`);


ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_evento_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`email`);
COMMIT;



GRANT USAGE ON *.* TO 'agenda_actualizarEvento'@'localhost' IDENTIFIED BY PASSWORD '*026E589F7B0D825DE7678BC784BDFE780E3A2A3E';

GRANT SELECT (fk_usuario, id), UPDATE (hora_inicio, hora_finalizacion, fecha_finalizacion, fecha_inicio) ON `agenda_db`.`eventos` TO 'agenda_actualizarEvento'@'localhost';



GRANT USAGE ON *.* TO 'agenda_crearEvento'@'localhost' IDENTIFIED BY PASSWORD '*C1634196913DF11AD82A3BECF0DE243E5979FFC5';

GRANT INSERT (fk_usuario, dia_completo, fecha_inicio, hora_finalizacion, hora_inicio, fecha_finalizacion, titulo) ON `agenda_db`.`eventos` TO 'agenda_crearEvento'@'localhost';


GRANT USAGE ON *.* TO 'agenda_crearUsuario'@'localhost' IDENTIFIED BY PASSWORD '*AB85013F5B4E3CF455E86889BAAEBF206D299F04';

GRANT INSERT ON `agenda_db`.`usuarios` TO 'agenda_crearUsuario'@'localhost';



GRANT USAGE ON *.* TO 'agenda_eliminarEvento'@'localhost' IDENTIFIED BY PASSWORD '*F22399E6B7566F63D77E25242FA4FE4227818E95';

GRANT SELECT (id, fk_usuario), DELETE ON `agenda_db`.`eventos` TO 'agenda_eliminarEvento'@'localhost';



GRANT USAGE ON *.* TO 'agenda_getEventosUsuario'@'localhost' IDENTIFIED BY PASSWORD '*C82EBF17EA50FC81DD9798C29F93DE8985548987';

GRANT SELECT ON `agenda_db`.`eventos` TO 'agenda_getEventosUsuario'@'localhost';


GRANT USAGE ON *.* TO 'agenda_login'@'localhost' IDENTIFIED BY PASSWORD '*067B6B0281103AEDB7E4C759E9CAE74655F44B8A';

GRANT SELECT (email, contrasena) ON `agenda_db`.`usuarios` TO 'agenda_login'@'localhost';

