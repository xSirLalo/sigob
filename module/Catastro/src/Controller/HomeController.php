<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;

class HomeController extends AbstractActionController
{
    private $opergobserviceadapter;

    public function __construct($opergobserviceadapter)
    {
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}
