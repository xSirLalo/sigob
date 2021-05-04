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

-- Volcando estructura para tabla sigob.documento_propiedad
CREATE TABLE IF NOT EXISTS `documento_propiedad` (
  `id_documento_propiedad` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_documento_propiedad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_documento_propiedad`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sigob.documento_propiedad: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `documento_propiedad` DISABLE KEYS */;
INSERT INTO `documento_propiedad` (`id_documento_propiedad`, `nombre_documento_propiedad`) VALUES
	(1, 'Titulo'),
	(2, 'Escritura'),
	(3, 'Certificado'),
	(4, 'Contrato del estado');
/*!40000 ALTER TABLE `documento_propiedad` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
