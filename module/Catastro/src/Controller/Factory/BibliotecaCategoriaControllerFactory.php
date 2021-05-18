<?php

declare(strict_types=1);

namespace Catastro\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\BibliotecaCategoriaManager;
use Catastro\Controller\BibliotecaCategoriaController;

class BibliotecaCategoriaControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $bibliotecaCategoriaManager = $container->get(BibliotecaCategoriaManager::class);

        // Instantiate the controller and inject dependencies
        return new BibliotecaCategoriaController($entityManager, $bibliotecaCategoriaManager);
    }
}
