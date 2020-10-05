<?php

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/../config/cli-bootstrap.php';

/** @var ContainerInterface $container */
$em = $container->get(EntityManager::class);

//$product = new Product();
//$product->setName('ORM');
//$product->setDescription('В этом руководстве объясняется базовое сопоставление сущностей и свойств. После изучения этого руководства вы должны знать:');
//
//$em->persist($product);
//
//$pr = new Product();
//$pr->setName('DBAL');
//$pr->setDescription('Тот факт, что Doctrine DBAL абстрагирует конкретный API PDO за счет использования интерфейсов, которые очень похожи на существующий API PDO, позволяет реализовать настраиваемые драйверы, которые могут использовать существующие собственные или самодельные API. Например, DBAL поставляется с драйвером для баз данных Oracle, который использует расширение oci8 под капотом.');
//
//$em->persist($pr);
//
//$pr2 = new Product();
//$pr2->setName('Slim');
//$pr2->setDescription('Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.');
//
//$em->persist($pr2);
//
//$em->flush();

$repo = $em->getRepository(Product::class);
$products = $repo->findAll();
foreach ($products as $product) {
    echo sprintf("%d. %s. %s\n", $product->getId(), $product->getName(), $product->getCreatedAt()->format('d.m.Y H:m:s'));
}

