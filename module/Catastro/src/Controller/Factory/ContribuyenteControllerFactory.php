<?php

declare(strict_types=1);

namespace Catastro\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\ContribuyenteManager;
use Catastro\Service\BibliotecaManager;
use Catastro\Controller\ContribuyenteController;
use Catastro\Model\Backend\OperGobServiceAdapter;

class ContribuyenteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $contribuyenteManager = $container->get(ContribuyenteManager::class);
        $bibliotecaManager = $container->get(BibliotecaManager::class);
        $opergobserviceadapter = $container->get(OperGobServiceAdapter::class);

        // Instantiate the controller and inject dependencies
        return new ContribuyenteController($entityManager, $contribuyenteManager, $bibliotecaManager, $opergobserviceadapter);
    }
}
