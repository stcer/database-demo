<?php

use demo\Entity\User;

require __DIR__ . '/bootstrap.php';

$newUsername = $argv[1];

$user = new User();
$user->setName($newUsername);

$entityManager = EM();
$entityManager->persist($user);
$entityManager->flush();

echo "Created User with ID " . $user->getId() . "\n";
