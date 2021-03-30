<?php

namespace Catastro\Service;

use Catastro\Entity\Archivo  as Biblioteca;
use Catastro\Entity\ArchivoPredio;
use Catastro\Entity\ArchivoContribuyente;
use Catastro\Entity\Contribuyente;
use Catastro\Entity\Predio;
use Catastro\Entity\ArchivoCategoria;

class BibliotecaManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function agregar($data)
    {
        $biblioteca = new Biblioteca();


        $this->entityManager->persist($biblioteca);
        $this->entityManager->flush();
    }

    public function actualizar($biblioteca, $data)
    {
        $this->entityManager->flush();
    }

    public function eliminar($biblioteca)
    {
        $this->entityManager->remove($biblioteca);

        $this->entityManager->flush();
    }

    public function getImageFileContent($filePath)
    {
        return file_get_contents($filePath);
    }

    public function guardarArchivosP($data, $categoria)
    {
        $file = new Biblioteca();

        $Categoria = $this->entityManager->getRepository(ArchivoCategoria::class)->findOneByIdArchivoCategoria($categoria);

        $file->setIdArchivoCategoria($Categoria);
        $file->setFile($data['archivoBlob']);
        $file->setExtension($data['extension']);
        $file->setSize($data['size']);
        $file->setUrl($data['archivoUrl']);

        $currentDate = new \DateTime();
        $file->setCreatedAt($currentDate);
        $file->setUpdatedAt($currentDate);

        $this->entityManager->persist($file);
        $this->entityManager->flush();

        if ($file->getIdArchivo() > 0) {
            return $file;
        }
        return null;
    }

    public function guardarRelacionAP($id, $archivito)
    {
        $filePredio = new ArchivoPredio();

        $Predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($id);
        if ($Predio == null) {
            throw new \Exception('ID: ' . $id . ' DOESN\'T EXIST');
        }

        $filePredio->setIdArchivo($archivito);
        $filePredio->setIdPredio($Predio);

        $this->entityManager->persist($filePredio);
        $this->entityManager->flush();
    }

    public function guardarRelacionAC($id, $archivito)
    {
        $fileContribuyente = new ArchivoContribuyente();

        $Contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($id);
        if ($Contribuyente == null) {
            throw new \Exception('ID: ' . $id . ' DOESN\'T EXIST');
        }

        $fileContribuyente->setIdArchivo($archivito);
        $fileContribuyente->setIdContribuyente($Contribuyente);

        $this->entityManager->persist($fileContribuyente);
        $this->entityManager->flush();
    }

    public function categorias()
    {
        $categorias  = $this->entityManager->createQuery("SELECT cat FROM Catastro\Entity\ArchivoCategoria cat ORDER BY cat.idArchivoCategoria ASC")->getResult();
        $fila = [];

        foreach ($categorias as $tupla) {
            $fila[$tupla->getIdArchivoCategoria()] = $tupla->getNombre();
        }

        return $fila;
    }
}
