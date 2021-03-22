<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;

class Module
{
    const VERSION = '3.0.0dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * This method is called once the MVC bootstrapping is complete.
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();

        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one to avoid passing the
        // session manager as a dependency to other models.
        $sessionManager = $serviceManager->get(SessionManager::class);

        $app = $event->getParam('application');
        $eventManager = $app->getEventManager();


        /** attach Front layout for 404 errors */
        // $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function (MvcEvent $event) {

           /** here you can retrieve anything from your serviceManager */
        //     $serviceManager = $event->getApplication()->getServiceManager();
        //     // $someVar = $serviceManager->get( 'Some\Factory' )->getSomeValue();

            /** here you redefine layout used to publish an error */
        //     $layout = $serviceManager->get('viewManager')->getViewModel();
        //     $layout->setTemplate('layout');

             /** here you redefine template used to the error exactly and pass custom variable into ViewModel */
        //     $viewModel = $event->getViewModel();
        //     $viewModel->setTemplate('error/404');
        // });
    }
}
