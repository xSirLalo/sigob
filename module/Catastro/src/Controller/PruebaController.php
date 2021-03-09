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
use Catastro\Form\PredioForm;
use Catastro\Form\BibliotecaForm;

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
        return new ViewModel();
    }
}
