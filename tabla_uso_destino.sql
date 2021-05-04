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

-- Volcando estructura para tabla sigob.uso_destino
CREATE TABLE IF NOT EXISTS `uso_destino` (
  `id_uso_destino` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_uso_destino` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_uso_destino`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sigob.uso_destino: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `uso_destino` DISABLE KEYS */;
INSERT INTO `uso_destino` (`id_uso_destino`, `nombre_uso_destino`) VALUES
	(1, 'Baldio'),
	(2, 'Urbano'),
	(3, 'Rustico'),
	(4, 'Comercial');
/*!40000 ALTER TABLE `uso_destino` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
