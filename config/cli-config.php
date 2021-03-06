<?php
//Insert in config folder as file name cli-config.php

require_once "vendor/autoload.php";

// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Create a simple "default" Doctrine ORM configuration for Annotations
$paths = array(__DIR__.'/../module/Catastro/src/Entity');
$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

// database configuration parameters
$conn = array(
    'driver'    => 'pdo_mysql',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'user'      => 'root',
    'password'  => '',
    'dbname'    => 'sigob',
    'charset'   => 'utf8',
    'driverOptions' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ]
);

$entityManager = EntityManager::create($conn, $config);

$migrationsConfiguration = $container->get('config')['doctrine']['migrations'];
$configuration = new \Doctrine\Migrations\Configuration\Configuration($entityManager->getConnection());
$configuration->setMigrationsDirectory($migrationsConfiguration['directory']);
$configuration->setName($migrationsConfiguration['name']);
$configuration->setMigrationsNamespace($migrationsConfiguration['namespace']);
$configuration->setMigrationsTableName($migrationsConfiguration['table']);
$configuration->setMigrationsColumnName($migrationsConfiguration['column']);
$configuration->createMigrationTable();
return new \Symfony\Component\Console\Helper\HelperSet([
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
        $entityManager
    ),
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper(
        $entityManager->getConnection()
    ),
    'configuration' => new \Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper(
        $entityManager->getConnection(),
        $configuration
    )
]);
// return ConsoleRunner::createHelperSet($entityManager);
