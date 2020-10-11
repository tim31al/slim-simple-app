<?php
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerInterface;

$startTime = microtime(true);

require_once __DIR__ . '/../../config/bootstrap.php';

/** @var ContainerInterface $container */
$em = $container->get(EntityManager::class);
$repoManager = $em->getRepository(User::class);

$em->getConnection()->getConfiguration()->setSQLLogger(null);
$d = $em->createQuery('delete from App\Entity\User u');
$rows = $d->execute();
echo sprintf("Delete %d row(s)\n", $rows);


foreach (User::ROLES as $u => $role) {
    $user = new User();
    $user->setUsername($u);
    $user->setPassword($u);
    $user->setEmail("${u}@mail.com");
    $user->setFullName(strtoupper($u));
    $user->setRole($role);
    if ($u === 'admin')
        $user->setActive(true);

    try {
        $em->persist($user);
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

$users =  $repoManager->findAll();
echo "Added:\n";
/* @var User $u */
foreach ($users as $u) {
    echo sprintf("%s\n%s\n%s\n\n", $u->getUsername(), $u->getEmail(), $u->getRole());
}

$runtime = microtime(true) - $startTime;
echo sprintf("Script '%s' run: %.4f ms\n", basename(__FILE__), (float)$runtime);
