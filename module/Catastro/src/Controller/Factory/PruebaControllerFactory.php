<?php
//    ▄███████▄    ▄████████ ███    █▄     ▄████████ ▀█████████▄     ▄████████
//   ███    ███   ███    ███ ███    ███   ███    ███   ███    ███   ███    ███
//   ███    ███   ███    ███ ███    ███   ███    █▀    ███    ███   ███    ███
//   ███    ███  ▄███▄▄▄▄██▀ ███    ███  ▄███▄▄▄      ▄███▄▄▄██▀    ███    ███
// ▀█████████▀  ▀▀███▀▀▀▀▀   ███    ███ ▀▀███▀▀▀     ▀▀███▀▀▀██▄  ▀███████████
//   ███        ▀███████████ ███    ███   ███    █▄    ███    ██▄   ███    ███
//   ███          ███    ███ ███    ███   ███    ███   ███    ███   ███    ███
//  ▄████▀        ███    ███ ████████▀    ██████████ ▄█████████▀    ███    █▀
//                ███    ███

declare(strict_types=1);

namespace Catastro\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Catastro\Service\PruebaManager;
use Catastro\Controller\PruebaController;
use Catastro\Model\Backend\OperGobServiceAdapter;

class PruebaControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $pruebaManager = $container->get(PruebaManager::class);
        $opergobserviceadapter = $container->get(OperGobServiceAdapter::class);

        // Instantiate the controller and inject dependencies
        return new PruebaController($entityManager, $pruebaManager, $opergobserviceadapter);
    }
}
