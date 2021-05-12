<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Catastro\Entity\Archivo as Biblioteca;
use Catastro\Entity\ArchivoCategoria as Categoria;
use Catastro\Form\EliminarForm;
use Catastro\Form\BiblitoecaCategoriaForm;

class BibliotecaCategoriaController extends AbstractActionController
{
    private $entityManager;
    private $bibliotecaCategoriaManager;

    public function __construct($entityManager, $bibliotecaCategoriaManager)
    {
        $this->entityManager = $entityManager;
        $this->bibliotecaCategoriaManager = $bibliotecaCategoriaManager;
    }

    public function indexAction()
    {
        $form = new BiblitoecaCategoriaForm();
        $categorias = $this->entityManager->getRepository(Categoria::class)->findAll();

        return new ViewModel([
            'form' => $form,
            'categorias' => $categorias
        ]);
    }

    public function addAction()
    {
        $form = new BiblitoecaCategoriaForm();
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $data = $this->params()->fromPost();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $data['status'] = true;
                $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                $this->bibliotecaCategoriaManager->agregar($data);
            } else {
                $data['status'] = false;
                $data['errors'] = $form->getMessages();
            };
            
            $json = new JsonModel($data);
            $json->setTerminal(true);
            return $json;

        } else {
            echo 'No Ajax';
        }
    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($request->isXmlHttpRequest()) {
            if ($id < 0) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            $resultado = $this->entityManager->getRepository(Categoria::class)->findOneByIdArchivoCategoria($id);
            
            if ($resultado == null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }

            $data = [
                'nombre' => $resultado->getNombre()
            ];

            $json = new JsonModel($data);
            $json->setTerminal(true);
            return $json;
        } else {
            echo 'No Ajax';
        }
    }

    public function editAction()
    {
        $form = new BiblitoecaCategoriaForm();
        $request = $this->getRequest();
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($request->isXmlHttpRequest()) {
            $data = $this->params()->fromPost();
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $data = $form->getData();
                    $data['status'] = true;
                    $categoria = $this->entityManager->getRepository(Categoria::class)->findOneByIdArchivoCategoria($id);
                    $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito');
                    $this->bibliotecaCategoriaManager->actualizar($categoria, $data);
                } else {
                    $data['status'] = false;
                    $data['errors'] = $form->getMessages();
                };

                $json = new JsonModel($data);
                $json->setTerminal(true);
                return $json;

        } else {
            echo 'No Ajax';
        }
    }

    public function deleteAction()
    {
        $form = new EliminarForm();
        $request = $this->getRequest();
        $categoriaId = (int)$this->params()->fromRoute('id', -1);

        if ($categoriaId < 0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $categoria = $this->entityManager->getRepository(Categoria::class)->findOneByIdArchivoCategoria($categoriaId);

        if ($categoria == null) {
            $this->getResponse()->setStatusCode(404);
            return;
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
