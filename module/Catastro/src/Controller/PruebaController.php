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
use Catastro\Entity\Predio;
use Catastro\Entity\Aportacion;
use Catastro\Entity\PredioColindancia;
use Catastro\Entity\Contribuyente;
use Catastro\Form\PruebaForm;

class PruebaController extends AbstractActionController
{
    private $entityManager;
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
        // $fecha = new \DateTime("now");
        // $data = $this->opergobserviceadapter->obtenerPredio("109015000050035-61");
        // $data = $this->opergobserviceadapter->AddSolicitud("11959");
        // $idSolicitud = $data->IdEntity;
        // $data2 = $this->opergobserviceadapter->SolicitudFuentaIngreso($idSolicitud,"1800");
        //$data = $this->opergobserviceadapter->obtenerLocalidadByCveEntidadFederativa("23", "09");
        //$apotacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion("20");
        //$data = $this->opergobserviceadapter->obtenerGiroComercialByCveFte('MTULUM', "2020");
        //$data = $this->opergobserviceadapter->obtenerGiroComercialByCveFte('MTULUM', "2020");
        //$data = $this->opergobserviceadapter->AgregarContribuyente("Eduardo","Cauich","Herrera","H","Soltero","lalo_lego@hotmail.com",0,"",$fecha,$fecha);
        // $data = $this->opergobserviceadapter->obtenerColindancia("1714");
        //$data = $this->opergobserviceadapter->obtenerColindancia("1714");
        //$data = $this->opergobserviceadapter->obtenerPersonaPorRfc("CABR840209R86");
        $data = $this->opergobserviceadapter->obtenerPersonaPorRfc("POPA450408K72");
        // $data = $this->opergobserviceadapter->obtenerNombrePersona("APOLINARIO");
        // $data = $this->opergobserviceadapter->obtenerPersonaPorCve("11959");
        // return new ViewModel(['data' => $data, 'data2' => $data2,'data3' => $data3]);
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
