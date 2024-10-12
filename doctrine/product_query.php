<?php


use demo\Entity\Product;

require __DIR__ . '/bootstrap.php';

$productRepository = EM()->getRepository(Product::class);
//$products = $productRepository->findBy(['id' => 1]);
$products = $productRepository->findAll();

foreach ($products as $product) {
    echo sprintf("-%s\n", $product->getName());
}
