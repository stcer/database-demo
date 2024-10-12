<?php

global $entityManager;

use demo\Entity\Product;

require __DIR__ . '/doctrine_boot.php';

$productRepository = $entityManager->getRepository(Product::class);
$products = $productRepository->findBy(['id' => 1]);

foreach ($products as $product) {
    echo sprintf("-%s\n", $product->getName());
}
