<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use Laminas\Filter;
use Laminas\InputFilter\OptionalInputFilter;
use Laminas\Http\Headers;
use Laminas\Http\Response\Stream;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Catastro\Entity\Archivo as Biblioteca;
use Catastro\Entity\Contribuyente;
use Catastro\Form\BibliotecaForm;

class BibliotecaController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Biblioteca Manager.
     * @var Catastro\Service\BibliotecaManager
     */
    private $bibliotecaManager;

    public function __construct($entityManager, $bibliotecaManager)
    {
        $this->entityManager = $entityManager;
        $this->bibliotecaManager = $bibliotecaManager;
    }

    public function indexAction()
    {

        // $page = $this->params()->fromQuery('page', 1);
        // $query = $this->entityManager->getRepository(Contribuyente::class)->createQueryBuilder('a')->getQuery();

        // $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        // $paginator = new Paginator($adapter);
        // $paginator->setDefaultItemCountPerPage(25);
        // $paginator->setCurrentPageNumber($page);
        // return new ViewModel(['contribuyentes' => $paginator]);

        // $predios        = $this->entityManager->createQuery("SELECT p FROM Catastro\\Entity\\Predio f")->getResult();
        // $contribuyentes = $this->entityManager->createQuery("SELECT c FROM Catastro\\Entity\\Contribuyente c")->getResult();

        // $bibliotecas = $this->entityManager->getRepository(Biblioteca::class)->findAll();
        // $contribuyentes = $this->entityManager->getRepository(Contribuyente::class)->findAll();
        // $view = new ViewModel(['contribuyentes' => $contribuyentes, 'asd' => "asdaosdkokasd"]);

        $contribuyentes = $this->entityManager->getRepository(Contribuyente::class)->findAll();
        return new ViewModel(['contribuyentes' => $contribuyentes]);
    }

    public function addAction()
    {
        $form = new BibliotecaForm();

        $request = $this->getRequest();
        $categorias = $this->bibliotecaManager->categorias();

        $destination = './public/img';

        // TODO: Se puede Optimizar

        if ($request->isPost()) {
            $data = \array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();
            $archivoUrl = (array) $this->params()->fromFiles('archivo');
            $archivoUrl = array_slice($archivoUrl, 0, 5); # we restrict to 5 fields i meant

            $categoria = (array) $this->params()->fromPost('id_archivo_categoria');
            $categoria = array_slice($categoria, 0, 5); # we restrict to 5 fields i meant

            $num = (int) count($archivoUrl);
            for ($i=0; $i < $num; $i++) {
                $newName = strtolower(str_replace(" ", "-", $archivoUrl[$i]['name']));

                $f_folder = $destination . '/' . $newName;

                if (file_exists($f_folder)) {
                    $this->flashMessenger()->addErrorMessage('El archivo existe! ' . $newName);
                    return $this->redirect()->toRoute('biblioteca/agregar');
                }

                $inputFilter = new OptionalInputFilter();
                $inputFilter->add([
                    'name' => 'archivo',
                    'filters' => [
                        [
                            'name' => Filter\File\Rename::class,
                            'options' => [
                                'target' => $destination . '/' . $newName,
                            ]
                        ]
                    ]
                ]);
                $form->setInputFilter($inputFilter);
            }
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $archivoUrl = (array) $this->params()->fromFiles('archivo');
                $archivoUrl = array_slice($archivoUrl, 0, 5); # we restrict to 5 fields i meant

                $categorias = (array) $this->params()->fromPost('id_archivo_categoria');
                $categorias = array_slice($categorias, 0, 5); # we restrict to 5 fields i meant

                $num = (int) count($archivoUrl);
                for ($i=0; $i < $num; $i++) {
                    $filename = $_FILES['archivo']['name'][$i];
                    $filesize = $_FILES['archivo']['size'][$i];
                    $tmp_name = $_FILES['archivo']['tmp_name'][$i];
                    $file_type = $_FILES['archivo']['type'][$i];
                    $date = date("d-m-Y_H-i");
                    $temp = explode(".", $filename);
                    $new_filename =   strtolower(str_replace(" ", "-", $temp[0])) . '.' . $temp[count($temp)-1];
                    $file_folder = $destination . '/' . $new_filename;

                    $data['archivoBlob'] = file_get_contents($file_folder, true);
                    $data['extension'] = $temp[count($temp)-1];
                    $data['size'] = $filesize;
                    $data['archivoUrl'] = strtolower(str_replace(" ", "-", $archivoUrl[$i]['name']));
                    $data['categoria'] = $categoria[$i];

                    $this->bibliotecaManager->guardarArchivos($data, $categoria[$i]);
                }
                $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                return $this->redirect()->toRoute('biblioteca');
            }
        }
        return new ViewModel(['form' => $form, 'categorias' => $categorias]);
    }

    public function viewAction()
    {
        $contribuyenteId = (int)$this->params()->fromRoute('id', -1);

        if ($contribuyenteId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

        if ($contribuyente == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->select('a')
            ->from('Catastro\Entity\Archivo', 'a')
            ->join('Catastro\Entity\Contribuyente', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.idContribuyente = c.idContribuyente')
            ->where('a.idContribuyente = :idParam')
            ->setParameter('idParam', $contribuyenteId)
            ->orderBy('a.createdAt', 'ASC');

        $resultados = $qb->getQuery()->getResult();

        return new ViewModel(['resultados' => $resultados, 'contribuyenteId' => $contribuyenteId]);
    }

    public function viewFileAction()
    {
    }

    public function deleteFileAction()
    {
        $id = (int)$this->params()->fromRoute('predio', -1);
        $archivoId = (int)$this->params()->fromRoute('archivo', -1);

        if ($id < 0 || $archivoId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
        }

        $file = $this->entityManager->getRepository(Biblioteca::class)->findOneByIdArchivo($archivoId);

        if ($id == null || $archivoId == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->delete('Catastro\Entity\ArchivoPredio', 'ap')
            ->where($qb->expr()->eq('ap.idPredio', ':idParam1'))
            ->andWhere($qb->expr()->eq('ap.idArchivo', ':idParam2'))
            ->setParameter('idParam1', $id)
            ->setParameter('idParam2', $archivoId);
        $qb->getQuery()->execute();

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->delete('Catastro\Entity\Archivo', 'a')
            ->Where($qb->expr()->eq('a.idArchivo', ':idParam2'))
            ->setParameter('idParam2', $archivoId);
        $qb->getQuery()->execute();

        \unlink('public/img/'. $file->getUrl());
        $this->flashMessenger()->addSuccessMessage('Se elimino con éxito!');
        // return $this->redirect()->toRoute('biblioteca/ver', ['id' => $id]);
        return $this->redirect()->toRoute('predio/ver', ['id' => $id]);
    }

    public function downloadFileAction()
    {
        $archivoId = (int)$this->params()->fromRoute('archivo', -1);

        $file = $this->entityManager->getRepository(Biblioteca::class)->findOneByIdArchivo($archivoId);

        if ($archivoId == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->select('Catastro\Entity\Archivo', 'a')
            ->andWhere($qb->expr()->eq('a.idArchivo', ':idParam2'))
            ->setParameter('idParam2', $archivoId);
        $qb->getQuery();

        $file = 'public/img/'. $file->getUrl();

        $response = new Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));

        $headers = new Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file)
        ));
        $response->setHeaders($headers);
        return $response;
    }

    public function deleteFile2Action()
    {
        $id = (int)$this->params()->fromRoute('predio', -1);
        $archivoId = (int)$this->params()->fromRoute('archivo', -1);

        if ($id < 0 || $archivoId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            // return $response->setTemplate('error/404');
        }

        $file = $this->entityManager->getRepository(Biblioteca::class)->findOneByIdArchivo($archivoId);

        if ($id == null || $archivoId == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            // return $response->setTemplate('error/404');
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->delete('Catastro\Entity\ArchivoPredio', 'ap')
            ->where($qb->expr()->eq('ap.idPredio', ':idParam1'))
            ->andWhere($qb->expr()->eq('ap.idArchivo', ':idParam2'))
            ->setParameter('idParam1', $id)
            ->setParameter('idParam2', $archivoId);
        $qb->getQuery()->execute();

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->delete('Catastro\Entity\Archivo', 'a')
            ->Where($qb->expr()->eq('a.idArchivo', ':idParam2'))
            ->setParameter('idParam2', $archivoId);
        $qb->getQuery()->execute();

        \unlink('public/img/'. $file->getUrl());
        $this->flashMessenger()->addSuccessMessage('Se elimino con éxito!');
        // return $this->redirect()->toRoute('biblioteca/ver', ['id' => $id]);
        return $this->redirect()->toRoute('predio/ver', ['id' => $id]);
    }

    public function downloadFile2Action()
    {
        $contribuyenteId = (int)$this->params()->fromRoute('contribuyente', -1);
        $archivoId = (int)$this->params()->fromRoute('archivo', -1);

        if ($contribuyenteId < 0 || $archivoId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
        }

        $file = $this->entityManager->getRepository(Biblioteca::class)->findOneByIdArchivo($archivoId);

        if ($contribuyenteId == null || $archivoId == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->select('Catastro\Entity\Archivo', 'a')
            ->where($qb->expr()->eq('a.idContribuyente', ':idParam1'))
            ->andWhere($qb->expr()->eq('a.idArchivo', ':idParam2'))
            ->setParameter('idParam1', $contribuyenteId)
            ->setParameter('idParam2', $archivoId);
        $qb->getQuery();

        $file = 'public/img/'. $file->getUrl();

        $response = new Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));

        $headers = new Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file)
        ));
        $response->setHeaders($headers);
        return $response;
    }
}
