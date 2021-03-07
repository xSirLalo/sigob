<?php

declare(strict_types=1);

namespace Catastro\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\BibliotecaManager;
use Catastro\Controller\BibliotecaController;

class BibliotecaControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $bibliotecaManager = $container->get(BibliotecaManager::class);

        // Instantiate the controller and inject dependencies
        return new BibliotecaController($entityManager, $bibliotecaManager);
    }
}
