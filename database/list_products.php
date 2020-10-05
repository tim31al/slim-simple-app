<?php


use App\Entity\Product;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/../config/cli-bootstrap.php';

/* @var ContainerInterface $container */
$em = $container->get(EntityManager::class);

$pr = $em->getRepository(Product::class);
$products = $pr->findAll();

foreach ($products as $product) {
    echo sprintf("%d. %s\n", $product->getId(), $product->getName());
}


echo "\n";
$line = readline('Enter product id: ');
$id = (int) $line;


$product = $pr->find($id);

echo sprintf("Find product with id: %d. %s\n", $product->getId(), $product->getName());

$newName = readline('New name: ');

$product->setName($newName);
$em->flush();

$products = $pr->findAll();
asort($products);


foreach ($products as $product) {
    echo sprintf("%d. %s\n", $product->getId(), $product->getName());
}
