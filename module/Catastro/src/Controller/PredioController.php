<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Catastro\Form\PredioForm;
use Catastro\Entity\Predio;
use Catastro\Entity\PredioColindancia;
use Catastro\Form\BibliotecaForm;

class PredioController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Predio Manager.
     * @var Catastro\Service\PredioManager
     */
    private $predioManager;
    private $bibliotecaManager;
    private $opergobserviceadapter;

    public function __construct($entityManager, $predioManager, $bibliotecaManager, $opergobserviceadapter)
    {
        $this->entityManager = $entityManager;
        $this->predioManager = $predioManager;
        $this->bibliotecaManager = $bibliotecaManager;
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = $this->entityManager->getRepository(Predio::class)->createQueryBuilder('p')->getQuery();

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel(['predios' => $paginator]);
    }

    public function addAction()
    {
        // https://stackoverflow.com/questions/2194317/how-to-combine-two-zend-forms-into-one-zend-form
        $form = new PredioForm();
        $form2 = new BibliotecaForm();
        $categorias = $this->bibliotecaManager->categorias();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->predioManager->guardar($data);
                $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                return $this->redirect()->toRoute('predio');
            }
        }
        return new ViewModel(['form' => $form, 'form2' => $form2, 'categorias' => $categorias]);
    }

    public function viewAction()
    {
        return new ViewModel();
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function searchCatastralAction()
    {
        $name = $_REQUEST['q'];
        $resultados = $this->opergobserviceadapter->obtenerPredio($name);
        $arreglo = [];
        $arreglo[] = [
                'id' => $resultados->Predio->PredioCveCatastral,
                'titular' => $resultados->Predio->PredioCveCatastral,
            ];
        $data = [
                'items' => $arreglo,
                'total_count' => count($arreglo),
            ];
        $json = new JsonModel($data);
        $json->setTerminal(true);
        return $json;
    }

    public function autofillCatastralAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $id = $this->params()->fromRoute('id');
            $WebService = $this->opergobserviceadapter->obtenerPredio($id);
            $WebService2 = $this->opergobserviceadapter->obtenerColindancia($WebService->Predio->PredioId);

            $data = [
                'titular'          => $WebService->Predio->Titular,
                'ubicacion'        => $WebService->Predio->NombreLocalidad,
                'titular_anterior' => $WebService->Predio->TitularCompleto,
                'predio_id'        => $WebService->Predio->PredioId,
                'con_norte'        => $WebService2->PredioColindancia[0]->Descripcion,
                'con_sur'          => $WebService2->PredioColindancia[1]->Descripcion,
                'con_este'         => $WebService2->PredioColindancia[2]->Descripcion,
                'con_oeste'        => $WebService2->PredioColindancia[3]->Descripcion,
                'norte'            => $WebService2->PredioColindancia[0]->MedidaMts,
                'sur'              => $WebService2->PredioColindancia[1]->MedidaMts,
                'este'             => $WebService2->PredioColindancia[2]->MedidaMts,
                'oeste'            => $WebService2->PredioColindancia[3]->MedidaMts,
            ];

            return $response->setContent(json_encode($data));
        } else {
            echo 'Error get data from ajax';
        }
    }
}
