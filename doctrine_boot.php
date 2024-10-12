<?php

require __DIR__ . '/vendor/autoload.php';

// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\Middleware;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger as Monolog;

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src/Entity/'],
    isDevMode: true,
);

$log = new Monolog('default');
$log->pushHandler(new StreamHandler(__DIR__ . '/storage/doctrine.log', Level::Debug));
$log->pushHandler(new StreamHandler('php://stdout', Level::Debug));
$config->setMiddlewares([new Middleware($log)]);

// configuring the database connection
$connection = DriverManager::getConnection([
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/storage/db.sqlite',
], $config);


// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);
