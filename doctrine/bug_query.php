<?php

// list_bugs.php
use demo\Entity\Bug;

require_once "bootstrap.php";

$bugClass = Bug::class;
$dql = "SELECT b, e, r FROM {$bugClass} b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";

$query = EM()->createQuery($dql);
$query->setMaxResults(30);
$bugs = $query->getResult();

foreach ($bugs as $bug) {
    echo $bug->getDescription()." - ".$bug->getCreated()->format('d.m.Y')."\n";
    echo "    Reported by: ".$bug->getReporter()->getName()."\n";
    echo "    Assigned to: ".$bug->getEngineer()->getName()."\n";
    foreach ($bug->getProducts() as $product) {
        echo "    Platform: ".$product->getName()."\n";
    }
    echo "\n";
}