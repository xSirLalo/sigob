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

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Catastro\Entity\Contriobuyente;
use Catastro\Entity\Predio;
use Catastro\Entity\Aportacion;
use Catastro\Entity\Biblioteca;
use Catastro\Entity\BibliotecaCategoria;
use Catastro\Entity\PredioColindancia;
use Catastro\Entity\Contribuyente;
use Catastro\Form\PruebaForm;

class PruebaController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Prueba Manager.
     * @var Catastro\Service\PruebaManager
     */
    private $pruebaManager;
    private $opergobserviceadapter;

    public function __construct($entityManager, $pruebaManager, $opergobserviceadapter)
    {
        $this->entityManager = $entityManager;
        $this->pruebaManager = $pruebaManager;
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function indexAction()
    {
        // $data = $this->opergobserviceadapter->obtenerPredio("109015000050035-61");
        // $data = $this->opergobserviceadapter->obtenerColindancia("1714");
        $data = $this->opergobserviceadapter->obtenerPersonaPorRfc("AVX130125SK7");
        // $data = $this->opergobserviceadapter->obtenerPersonaPorCve("11959");

        return new ViewModel(['data' => $data]);
    }

    public function addAction()
    {
        $form = new PruebaForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();

                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                // exit();

                // $this->pruebaManager->guardarPrueba($data);
                $this->flashMessenger()->addWarningMessage($data);
                return $this->redirect()->toRoute('prueba/agregar');
            }
        }

        return new ViewModel(['form' => $form]);
    }
}
