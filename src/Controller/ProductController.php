<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductController extends BaseController
{

    private EntityManager $em;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->em = $container->get(EntityManager::class);
    }

    public function index(Request $request, Response $response)
    {
        $products = ($this->em->getRepository(Product::class))->findAll();

        return $this->render($response, 'product/index.php', [
            'products' => $products
        ]);
    }

    public function view(Request $request, Response $response)
    {
        $id = (int)$request->getAttribute('id');
        $product = ($this->em->getRepository(Product::class))->find($id);

        return $this->render($response, 'product/view.php', [
            'product' => $product
        ]);
    }
}