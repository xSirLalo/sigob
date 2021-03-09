<?php

declare(strict_types=1);

namespace Catastro\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\PredioManager;
use Catastro\Controller\PredioController;
use Catastro\Model\Backend\OperGobServiceAdapter;

class PredioControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $predioManager = $container->get(PredioManager::class);
        $opergobserviceadapter = $container->get(OperGobServiceAdapter::class);

        // Instantiate the controller and inject dependencies
        return new PredioController($entityManager, $predioManager, $opergobserviceadapter);
    }
}
