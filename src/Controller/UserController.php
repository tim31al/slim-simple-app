<?php


namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class UserController extends AbstractController
{
    private EntityManager $em;
    private EntityRepository $repo;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->em = $container->get(EntityManager::class);
        $this->repo = ($container->get(EntityManager::class))->getRepository(User::class);
    }

    public function index(Request $request, Response $response)
    {
        $users = ($this->em->getRepository(User::class))->findAll();

        return $this->render($response, 'user/index.php', [
            'users' => $users
        ]);
    }

    public function view(Request $request, Response $response)
    {
        $id = (int)$request->getAttribute('id');
        $user = $this->repo->find($id);

        return $this->render($response, 'user/view.php', [
            'user' => $user
        ]);
    }

}