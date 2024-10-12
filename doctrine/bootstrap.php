<?php

require __DIR__ . '/../vendor/autoload.php';

// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\Middleware;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger as Monolog;

function EM()
{
    static $entityManager;

    if (isset($entityManager)) {
        return $entityManager;
    }

    // Create a simple "default" Doctrine ORM configuration for Attributes
    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: [__DIR__ . '/../src/Entity/'],
        isDevMode: true,
    );

    $config->setMiddlewares([new Middleware(logger())]);

    // configuring the database connection
    $connection = DriverManager::getConnection([
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../storage/db.sqlite',
    ], $config);


    // obtaining the entity manager
    $entityManager = new EntityManager($connection, $config);

    return $entityManager;
}

function logger()
{
    static $logger;
    if (!isset($logger)) {
        $logger = new Monolog('default');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../storage/doctrine.log', Level::Debug));
        $logger->pushHandler(new StreamHandler('php://stdout', Level::Debug));
    }
    return $logger;
}

$entityManager = EM();

class_alias(\demo\Entity\User::class, 'User');
class_alias(\demo\Entity\Product::class, 'Product');
class_alias(\demo\Entity\Bug::class, 'Bug');