<?php

namespace Catastro\Service;

use Catastro\Entity\Predio;
use Catastro\Entity\PredioColindancia;
use Catastro\Entity\Aportacion;
use Catastro\Entity\Contribuyente;
use Catastro\Model\Backend\OperGobServiceAdapter;

class AportacionManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;
    private $opergobserviceadapter;
    /**
     * Constructor.
     */
    public function __construct($entityManager, $opergobserviceadapter)
    {
        $this->entityManager = $entityManager;
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function guardarModal($data)
    {
        $aportacion = new Aportacion();
        $predio = new Predio();

        $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($data['contribuyente_id']);
        $aportacion->setIdContribuyente($contribuyentebd);
        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($data['id_predio']);
        $aportacion->setIdPredio($prediobd);
        $aportacion->setPago($data['pago_a']);
        $fecha = new \DateTime($data['vig']);
        $aportacion->setFecha($fecha);
        $aportacion->setMetrosTerreno($data['terreno']);
        $aportacion->setMetrosConstruccion($data['sup_m']);
        $aportacion->setValorTerreno($data['v_terreno']);
        $aportacion->setValorConstruccion($data['v_c']);
        $aportacion->setAvaluo($data['a_total']);
        $aportacion->setEstatus($data['status']);

        $currentDate = new \DateTime();
        $aportacion->setCreatedAt($currentDate);
        $aportacion->setUpdatedAt($currentDate);

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();
    }

    public function guardar($data)
    {
        $aportacion = new Aportacion();
        $contribuyente = new Contribuyente();
        $predio = new Predio();
        $predioColindacia = new PredioColindancia();


        // if ($this->opergobserviceadapter->obtenerPersonaPorRfc($data['id']) < 0) {
        //     $contribuyenteIdWeb = $contribuyentesWeb->Persona[0]->CvePersona;

        //     $contribuyente->setIdContribuyente($contribuyenteIdWeb);
        //     $contribuyente->setRfc($contribuyentesWeb->Persona[0]->RFCPersona);
        //     $contribuyente->setNombre($contribuyentesWeb->Persona[0]->NombreCompletoPersona);
        //     $contribuyente->setApellidoMaterno($contribuyentesWeb->Persona[0]->ApellidoMaternoPersona);
        //     $contribuyente->setApellidoPaterno($contribuyentesWeb->Persona[0]->ApellidoPaternoPersona);
        //     $contribuyente->setCurp($contribuyentesWeb->Persona[0]->CURPPersona);

        //     $this->entityManager->persist($contribuyente);
        //     $this->entityManager->flush();
        // }

        // $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteIdWeb);
        $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($data['parametro']);
        $predio->setIdContribuyente($contribuyentebd);

        $prediosWeb = $this->opergobserviceadapter->obtenerPredio($data['contribuyente_id']);
        $predioIdWeb = $prediosWeb->Predio->PredioId;

        $predio->setIdPredio($predioIdWeb);
        $predio->setClaveCatastral($data['contribuyente_id']);
        $predio->setUbicacion($data['ubicacion']);
        $predio->setTitular($data['titular']);
        $predio->setTitularAnterior($data['titular_anterior']);

        $this->entityManager->persist($predio);
        $this->entityManager->flush();

        $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteIdWeb);
        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioIdWeb);

        $aportacion->setIdContribuyente($contribuyentebd);
        $aportacion->setIdPredio($prediobd);
        $aportacion->setPago($data['pago_a']);
        $aportacion->setAvaluo($data['a_total']);
        $aportacion ->setEstatus($data['status']);
        $fecha = new \DateTime($data['vig']);
        $aportacion->setFecha($fecha);
        $aportacion ->setMetrosTerreno($data['terreno']);
        $aportacion ->setMetrosConstruccion($data['sup_m']);
        $aportacion ->setValorTerreno($data['v_terreno']);
        $aportacion ->setValorConstruccion($data['v_c']);

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();

        $prediosColindaciasWeb = $this->opergobserviceadapter->obtenerColindancia($predioIdWeb);
        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioIdWeb);
        $num = (int) \count($prediosColindaciasWeb->PredioColindancia);
        for ($i=0; $i < $num; $i++) {
            $predioColindacia->setIdPredio($prediobd);
            $predioColindacia->setDescripcion($prediosColindaciasWeb->PredioColindancia[$i]->Descripcion);
            $predioColindacia->setMedidaMetros($prediosColindaciasWeb->PredioColindancia[$i]->MedidaMts);
            $predioColindacia->setOrientacionGeografica($prediosColindaciasWeb->PredioColindancia[$i]->OrientacionGeografica);

            $this->entityManager->persist($predioColindacia);
            $this->entityManager->flush();
        }
    }

    public function actualizar($aportacion, $data)
    {
        $aportacion->setPago($data['pago']);

        $currentDate = new \DateTime();
        $aportacion->setUpdatedAt($currentDate);

        $this->entityManager->flush();
    }

    public function eliminar($aportacion)
    {
        $this->entityManager->remove($aportacion);

        $this->entityManager->flush();
    }
}
