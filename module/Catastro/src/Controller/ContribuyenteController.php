<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Application\Entity\Contribuyente;
use Catastro\Form\ContribuyenteForm;
use Catastro\Form\EliminarForm;

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
        $form = new ContribuyenteForm();
        $page = $this->params()->fromQuery('page', 1);
        $query = $this->entityManager->getRepository(Contribuyente::class)->createQueryBuilder('c')->getQuery();

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);
        return new ViewModel(['contribuyentes' => $paginator, 'form' => $form]);
    }

    public function addAction()
    {
        $form = new ContribuyenteForm();

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $data = $this->params()->fromPost();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $data['status'] = true;
                $this->contribuyenteModel->agregar($data);
            } else {
                $data['status'] = false;
                $data['errors'] = $form->getMessages();
            };
            $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
            $view = new JsonModel($data);
            $view->setTerminal(true);
        } else {
            if ($this->getRequest()->isPost()) {
                $data = $this->params()->fromPost();
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $this->contribuyenteModel->agregar($data);
                    return $this->redirect()->toRoute('contribuyente');
                }
            }
            $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
            $view = new ViewModel(['form' => $form]);
        }
        return $view;
    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $contribuyenteId = (int)$this->params()->fromRoute('id', -1);
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
            $data = [
                'id_contribuyente' => $contribuyente->getIdContribuyente(),
                'nombre' => $contribuyente->getNombre(),
                'apellido_paterno' => $contribuyente->getApellidoPaterno(),
                'apellido_materno' => $contribuyente->getApellidoMaterno(),
                'rfc' => $contribuyente->getRfc(),
                'curp' => $contribuyente->getCurp(),
                'genero' => $contribuyente->getGenero(),
            ];

            $view = new JsonModel($data);
            $view->setTerminal(true);
        } else {
            if ($contribuyenteId < 0) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

            if ($contribuyente == null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            $view = new ViewModel(['contribuyente' => $contribuyente]);
        }
        return $view;
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $form = new ContribuyenteForm();
        $contribuyenteId = (int)$this->params()->fromRoute('id', -1);

        if ($request->isXmlHttpRequest()) {
            $data = $this->params()->fromPost();
            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $data = $form->getData();
                    $data['status'] = true;
                    $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
                    $this->contribuyenteModel->actualizar($contribuyente, $data);
                } else {
                    $data['status'] = false;
                    $data['errors'] = $form->getMessages();
                };
                $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito');
                $view = new JsonModel($data);
                $view->setTerminal(true);
            }
        } else {
            if ($contribuyenteId < 0) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

            if ($contribuyente == null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            if ($this->getRequest()->isPost()) {
                $data = $this->params()->fromPost();
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $this->contribuyenteModel->actualizar($contribuyente, $data);
                    return $this->redirect()->toRoute('contribuyente');
                }
            } else {
                $data = [
                'nombre' => $contribuyente->getNombre(),
                'apellido_paterno' => $contribuyente->getApellidoPaterno(),
                'apellido_materno' => $contribuyente->getApellidoMaterno(),
                'rfc' => $contribuyente->getRfc(),
                'curp' => $contribuyente->getCurp(),
                'genero' => $contribuyente->getGenero(),
                ];
                $form->setData($data);
                $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito');
            }
            $view = new ViewModel(['form' => $form]);
        }
        return $view;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $form = new EliminarForm();
        $contribuyenteId = (int)$this->params()->fromRoute('id', -1);

        if ($request->isXmlHttpRequest()) {
            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
            $this->contribuyenteModel->eliminar($contribuyente);

            $this->flashMessenger()->addSuccessMessage('Se elimino con éxito');
            $view = new JsonModel();
            $view->setTerminal(true);
        } else {
            if ($contribuyenteId < 0) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

            if ($contribuyente == null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            if ($this->getRequest()->isPost()) {
                $data = $this->params()->fromPost();
                $form->setData($data);
                if ($form->isValid()) {
                    if ($this->getRequest()->getPost()->get('delete') == 'Yes') {
                        $this->flashMessenger()->addSuccessMessage('Se elimino con éxito!');
                        $this->contribuyenteModel->eliminar($contribuyente);
                    }
                    return $this->redirect()->toRoute('contribuyente');
                }
            }
            $view = new ViewModel(['form' => $form, 'id' => $contribuyenteId]);
        }
        return $view;
    }

    public function searchAjaxAction()
    {
    }

    public function pdfAction()
    {
    }
}
