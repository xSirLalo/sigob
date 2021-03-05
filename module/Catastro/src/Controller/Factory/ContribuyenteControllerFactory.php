<?php

namespace Catastro\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\ContribuyenteModel;
use Catastro\Controller\ContribuyenteController;

class ContribuyenteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $contribuyenteModel = $container->get(ContribuyenteModel::class);

        // Instantiate the controller and inject dependencies
        return new ContribuyenteController($entityManager, $contribuyenteModel);
    }
}
