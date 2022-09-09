<?php
use Config\DBConnectionFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

include_once __DIR__ . '/../../vendor/autoload.php';
include_once __DIR__ . '/../Config/Config.php';

$connection = DBConnectionFactory::getDbConfig();
$db_config = ORMSetup::createAnnotationMetadataConfiguration(
    [
        APP_PATH."src/Module/User/Entity",
    ],
    ENVIRONMENT == 'development',
    null,
    null,
    false
);
$entityManager = EntityManager::create($connection, $db_config);

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);