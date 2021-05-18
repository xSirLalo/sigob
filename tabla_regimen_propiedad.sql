-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla sigob.regimen_propiedad
CREATE TABLE IF NOT EXISTS `regimen_propiedad` (
  `id_regimen_propiedad` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_regimen_propiedad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_regimen_propiedad`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sigob.regimen_propiedad: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `regimen_propiedad` DISABLE KEYS */;
INSERT INTO `regimen_propiedad` (`id_regimen_propiedad`, `nombre_regimen_propiedad`) VALUES
	(1, 'Urbano '),
	(2, 'Rustico');
/*!40000 ALTER TABLE `regimen_propiedad` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
