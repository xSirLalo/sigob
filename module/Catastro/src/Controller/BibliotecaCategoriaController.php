<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Catastro\Entity\Archivo as Biblioteca;
use Catastro\Entity\ArchivoCategoria as Categoria;
use Catastro\Form\EliminarForm;
use Catastro\Form\BiblitoecaCategoriaForm;

class BibliotecaCategoriaController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Biblioteca Manager.
     * @var Catastro\Service\BibliotecaCategoriaManager
     */
    private $bibliotecaCategoriaManager;

    public function __construct($entityManager, $bibliotecaCategoriaManager)
    {
        $this->entityManager = $entityManager;
        $this->bibliotecaCategoriaManager = $bibliotecaCategoriaManager;
    }

    public function indexAction()
    {
        // $form = new ContribuyenteForm();

        // $page = $this->params()->fromQuery('page', 1);
        // $query = $this->entityManager->getRepository(Biblioteca::class)->createQueryBuilder('a')->getQuery();

        // $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        // $paginator = new Paginator($adapter);
        // $paginator->setDefaultItemCountPerPage(5);
        // $paginator->setCurrentPageNumber($page);
        // return new ViewModel(['bibliotecas' => $paginator]);
        $categorias = $this->entityManager->getRepository(Categoria::class)->findAll();
        return new ViewModel(['categorias' => $categorias]);
    }

    public function addAction()
    {
        $form = new BiblitoecaCategoriaForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->bibliotecaCategoriaManager->agregar($data);
                $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                return $this->redirect()->toRoute('categoria');
            }
        }
        return new ViewModel(['form' => $form]);
    }

    public function viewAction()
    {
        $categoriaId = (int)$this->params()->fromRoute('id', -1);

        if ($categoriaId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $categoria = $this->entityManager->getRepository(Categoria::class)->findOneByIdArchivoCategoria($categoriaId);

        if ($categoria == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        return new ViewModel(['categoria' => $categoria]);
    }

    public function editAction()
    {
        $form = new BiblitoecaCategoriaForm();
        $request = $this->getRequest();
        $categoriaId = (int)$this->params()->fromRoute('id', -1);

        if ($categoriaId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $categoria = $this->entityManager->getRepository(Categoria::class)->findOneByIdArchivoCategoria($categoriaId);

        if ($categoria == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->bibliotecaCategoriaManager->actualizar($categoria, $data);
                return $this->redirect()->toRoute('categoria');
            }
        } else {
            $data = [
                'nombre' => $categoria->getNombre(),
                ];
            $form->setData($data);
            $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito');
        }
        return new ViewModel(['form' => $form]);
    }

    public function deleteAction()
    {
        $form = new EliminarForm();
        $request = $this->getRequest();
        $categoriaId = (int)$this->params()->fromRoute('id', -1);

        if ($categoriaId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $categoria = $this->entityManager->getRepository(Categoria::class)->findOneByIdArchivoCategoria($categoriaId);

        if ($categoria == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                if ($this->getRequest()->getPost()->get('delete') == 'Yes') {
                    $this->flashMessenger()->addSuccessMessage('Se elimino con éxito!');
                    $this->bibliotecaCategoriaManager->eliminar($categoria);
                }
                return $this->redirect()->toRoute('categoria');
            }
        }
        return new ViewModel(['form' => $form, 'id' => $categoriaId]);
    }
}