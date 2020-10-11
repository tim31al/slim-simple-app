<?php

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerInterface;

$startTime = microtime(true);

require_once __DIR__ . '/../../config/bootstrap.php';

/** @var ContainerInterface $container */
$em = $container->get(EntityManager::class);
$repoManager = $em->getRepository(Product::class);

$em->getConnection()->getConfiguration()->setSQLLogger(null);
$d = $em->createQuery('delete from App\Entity\Product p');
$rows = $d->execute();
echo sprintf("Delete %d row(s)\n", $rows);


$maxEntry = 5;
for ($i = 1; $i <= $maxEntry; $i++) {
    $product = new Product();
    $product->setName('Product ' . $i);
    $product->setDescription('Description product ' . $i);

    try {
        $em->persist($product);
    } catch (ORMException $e) {
        echo $e->getMessage();
        exit($e->getCode());
    }
}

try {
    $em->flush();
} catch (OptimisticLockException $e) {
} catch (ORMException $e) {
    echo $e->getMessage();
    exit($e->getCode());
}


$products = $repoManager->findAll();
echo "Added:\n";
/* @var Product $p */
foreach ($products as $p) {
    echo sprintf("%s\n%s\n%s\n",
        $p->getName(),
        $p->getDescription(),
        $p->getCreatedAt()->format('d.m.Y H:m:s'));
}

$runtime = microtime(true) - $startTime;
echo sprintf("\nScript '%s' run: %.4f ms\n", basename(__FILE__), (float)$runtime);