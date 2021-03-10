<?php

namespace Catastro\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\AportacionManager;
use Catastro\Model\Backend\OperGobServiceAdapter;
class AportacionFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $opergobserviceadapter = $container->get(OperGobServiceAdapter::class);

        return new AportacionManager($entityManager, $opergobserviceadapter);
    }
}
