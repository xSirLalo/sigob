<?php

declare(strict_types=1);

namespace Catastro\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\AportacionManager;
use Catastro\Controller\AportacionController;

class AportacionControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $aportacionManager = $container->get(AportacionManager::class);

        // Instantiate the controller and inject dependencies
        return new AportacionController($entityManager, $aportacionManager);
    }
}
