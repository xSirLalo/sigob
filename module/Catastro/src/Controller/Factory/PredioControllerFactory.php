<?php

declare(strict_types=1);

namespace Catastro\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\PredioManager;
use Catastro\Service\ContribuyenteManager;
use Catastro\Service\BibliotecaManager;
use Catastro\Controller\PredioController;
use Catastro\Model\Backend\OperGobServiceAdapter;

class PredioControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $predioManager = $container->get(PredioManager::class);
        $contribuyenteManager = $container->get(ContribuyenteManager::class);
        $bibliotecaManager = $container->get(BibliotecaManager::class);
        $opergobserviceadapter = $container->get(OperGobServiceAdapter::class);

        // Instancia el controlador e inyecta las dependencias
        return new PredioController($entityManager, $predioManager, $contribuyenteManager, $bibliotecaManager, $opergobserviceadapter);
    }
}
