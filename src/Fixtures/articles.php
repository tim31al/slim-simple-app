<?php
declare(strict_types=1);

use App\Entity\Article;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerInterface;

$startTime = microtime(true);

require_once __DIR__ . '/../../config/cli-bootstrap.php';

/** @var ContainerInterface $container */
$em = $container->get(EntityManager::class);
$repoManager = $em->getRepository(Article::class);

// Удалить все записи
$em->getConnection()->getConfiguration()->setSQLLogger(null);
$d = $em->createQuery('delete from App\Entity\Article a');
$rows = $d->execute();

echo sprintf("Delete %d row(s)\n", $rows);

// Создать 5 записей
$maxEntry = 5;
for ($i = 1; $i <= $maxEntry; $i++) {
    $article = new Article();
    $article->setTitle('Article ' . $i);
    $article->setContent('Content article ' . $i);
    $article->setDate((new DateTime())->modify('-' . rand(1, 31)));

    try {
        $em->persist($article);
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

$articles = $repoManager->findAll();
echo "Added:\n";
/* @var Article $a */
foreach ($articles as $a) {
    echo sprintf("%s\n%s\n%s\n\n", $a->getTitle(), $a->getContent(), $a->getDate()->format('d.m.Y H:m:s'));
}

$runtime = microtime(true) - $startTime;
echo sprintf("\nScript '%s' run: %.4f ms\n", basename(__FILE__), (float)$runtime);