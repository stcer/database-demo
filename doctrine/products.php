<?php
// products.php
use demo\Entity\Bug;

require_once "bootstrap.php";

$bugClass = Bug::class;
$dql = "SELECT p.id, p.name, count(b.id) AS openBugs FROM {$bugClass} b ".
    "JOIN b.products p WHERE b.status = 'OPEN' GROUP BY p.id";
$productBugs = EM()->createQuery($dql)->getScalarResult();

foreach ($productBugs as $productBug) {
    echo $productBug['name']." has " . $productBug['openBugs'] . " open bugs!\n";
}

$productCount = EM()->getRepository(Product::class)
    ->count(['name' => 'Demo']);

var_dump($productCount);