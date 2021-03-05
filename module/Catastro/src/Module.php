<?php
declare(strict_types=1);

namespace Catastro;

use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * This method is called once the MVC bootstrapping is complete.
     */
    public function onBootstrap(MvcEvent $event)
    {
        $sessionManager = $event->getApplication()->getServiceManager()->get('Laminas\Session\SessionManager');

        $this->forgetInvalidSession($sessionManager);

        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();

        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one.
        $sessionManager = $serviceManager->get(SessionManager::class);

        // Get language settings from session.
        $container = $serviceManager->get('I18nSessionContainer');

        $languageId = 'es_ES';
        if (isset($container->languageId)) {
            $languageId = $container->languageId;
        }

        \Locale::setDefault($languageId);

        $translator = $event->getApplication()->getServiceManager()->get('MvcTranslator');
        $translator->addTranslationFile(
            'phpArray',
            './vendor/laminas/laminas-i18n-resources/languages/'.substr($languageId, 0, 2).'/Laminas_Validate.php',
            'default',
            $languageId
        );
        $translator->addTranslationFilePattern(
            'phpArray',
            './data/language',
            '%s.php',
            'default'
        );

        \Laminas\Validator\AbstractValidator::setDefaultTranslator(new \Laminas\Mvc\I18n\Translator($translator));
    }
    protected function forgetInvalidSession($sessionManager)
    {
        try {
            $sessionManager->start();
            return;
        } catch (\Exception $e) {
        }
        /**
         * Session validation failed: toast it and carry on.
         */
        // @codeCoverageIgnoreStart
        session_unset();
        // @codeCoverageIgnoreEnd
    }
}
