<?php
namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;

class HomeController extends AbstractActionController
{
    private $i18nSessionContainer;
    private $opergobserviceadapter;

    public function __construct($i18nSessionContainer, $opergobserviceadapter)
    {
        $this->i18nSessionContainer = $i18nSessionContainer;
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function indexAction()
    {
        //$resultado = $this->opergobserviceadapter->obtenerPersonaPorRfc("AVX130125SK7");
        // $resultado = $this->opergobserviceadapter->obtenerPersonaPorRfc("AVX130125SK7");
        // $resultado = $this->opergobserviceadapter->obtenerPersonaPorRfc("SAAM920510QQ6");
        // $resultado = $this->opergobserviceadapter->obtenerPredio("109006000020047-");
        // $resultado = $this->opergobserviceadapter->obtenerColindancia("730");

        // echo "<pre>";
        // print_r($resultado->PredioColindancia[0]->Descripcion);
        // echo "</pre>";
        // exit();
        // return new ViewModel(['datos' => $resultado]);

        return new ViewModel();
    }

    public function setLanguageAction()
    {
        $languageId = $this->params()->fromRoute('id', 'en_US');
        $this->i18nSessionContainer->languageId = $languageId;

        return $this->redirect()->toRoute('home');
    }
}
