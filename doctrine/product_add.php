<?php

use demo\Entity\Product;

require __DIR__ . '/bootstrap.php';

$newProductName = $argv[1] ?? '测试产品';

$product = new Product();
$product->setName($newProductName);
$product->setPrice(0.5);

$entityManager = EM();
$entityManager->persist($product);
$entityManager->flush();
