<?php
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/../config/cli-bootstrap.php';

/** @var ContainerInterface $container */
$em = $container->get(EntityManager::class);

$repo = $em->getRepository(User::class);
$users =  $repo->findAll();
foreach ($users as $user)
    $em->remove($user);

$em->flush();

$admin = new User('alex', 'tim31al@mail.com', 'r477ed', 'Alex', true, 'ROLE_ADMIN');
$user = new User('user', 'user@mail.com', 'user', 'USer Name', false, 'ROLE_USER');

$em->persist($admin);
$em->persist($user);
$em->flush();



$admin->setLastVisit(new DateTime());
$creator = new User('creator', 'cr@mail.com', 'pass', 'Creat', true, 'ROLE_CREATOR');

$em->persist($admin);
$em->persist($creator);
$em->flush();

$users =  $repo->findAll();

print_r($admin);

foreach ($users as $user) {
    print_r($user);
}