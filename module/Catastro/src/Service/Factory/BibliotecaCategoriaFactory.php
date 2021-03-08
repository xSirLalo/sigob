<?php

namespace Catastro\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\BibliotecaCategoriaManager;

class BibliotecaCategoriaFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new BibliotecaCategoriaManager($entityManager);
    }
}
