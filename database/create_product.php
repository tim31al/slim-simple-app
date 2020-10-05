<?php
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/../config/cli-bootstrap.php';

/** @var ContainerInterface $container */
$em = $container->get(EntityManager::class);
$products = [];
for ($i = 1; $i < $argc; $i++) {
    $newProductName = $argv[$i];

    $product = new Product();
    $product->setName($newProductName);

    $em->persist($product);

    array_push($products, $product);

}

$em->flush();

foreach ($products as $product)

echo 'Created product with ID: ' . $product->getId() . "\n";