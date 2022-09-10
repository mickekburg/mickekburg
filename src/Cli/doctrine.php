<?php
use Config\DBConnectionFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

include_once __DIR__ . '/../../vendor/autoload.php';
include_once __DIR__ . '/../Config/Config.php';

$connection = DBConnectionFactory::getDbConfig();
$db_config = ORMSetup::createAttributeMetadataConfiguration(
    [
        APP_PATH."src/Module/User/Entity",
    ],
    ENVIRONMENT == 'development',
    null,
    null,
    false
);
try {
    $entityManager = EntityManager::create($connection, $db_config);
} catch (\Doctrine\DBAL\Exception $e) {
    exit("Cli dbal exception");
} catch (\Doctrine\ORM\Exception\ManagerException $e) {
    exit("Cli manager exception");
}

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);