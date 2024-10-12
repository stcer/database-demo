<?php

global $entityManager;

use demo\Entity\Product;

require __DIR__ . '/doctrine_boot.php';

$newProductName = $argv[1] ?? '测试产品';

$product = new Product();
$product->setName($newProductName);
$product->setPrice(0.5);

$entityManager->persist($product);
$entityManager->flush();
