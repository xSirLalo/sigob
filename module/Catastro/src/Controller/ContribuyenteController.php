<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Catastro\Entities\Contribuyente;
use Catastro\Form\ContribuyenteForm;

class ContribuyenteController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Post manager.
     * @var Catastro\Service\ContribuyenteModel
     */
    private $contribuyenteModel;

    public function __construct($entityManager, $contribuyenteModel)
    {
        $this->entityManager = $entityManager;
        $this->contribuyenteModel = $contribuyenteModel;
    }

    public function indexAction()
    {
        $contribuyentes = $this->entityManager->getRepository(Contribuyente::class)->findAll();
        return new ViewModel(['contribuyentes' => $contribuyentes]);
    }

    public function addAction()
    {
        $form = new ContribuyenteForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->contribuyenteModel->agregar($data);
                return $this->redirect()->toRoute('contribuyente');
            }
        }
        return new ViewModel(['form' => $form]);
    }

    public function viewAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function addAjaxAction()
    {
    }

    public function viewAjaxAction()
    {
    }

    public function editAjaxAction()
    {
    }

    public function searchAjaxAction()
    {
    }

    public function pdfAction()
    {
    }
}
