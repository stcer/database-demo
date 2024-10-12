<?php
// // update_product.php <id> <new-name>
use demo\Entity\Product;

require __DIR__ . '/bootstrap.php';

$id = $argv[1];
$newName = $argv[2];

$product = EM()->find(Product::class, $id);

if ($product === null) {
    echo "Product $id does not exist.\n";
    exit(1);
}

$product->setName($newName);
EM()->flush();