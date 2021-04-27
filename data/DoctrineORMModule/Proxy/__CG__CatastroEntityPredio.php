<?php

namespace DoctrineORMModule\Proxy\__CG__\Catastro\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Predio extends \Catastro\Entity\Predio implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array<string, null> properties to be lazy loaded, indexed by property name
     */
    public static $lazyPropertiesNames = array (
);

    /**
     * @var array<string, mixed> default values of properties to be lazy loaded, with keys being the property names
     *
     * @see \Doctrine\Common\Proxy\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array (
);



    public function __construct(?\Closure $initializer = null, ?\Closure $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'idPredio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'parcela', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'manzana', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'lote', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'local', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'categoria', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'condicion', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'titular', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'ubicacion', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'localidad', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'antecedentes', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'claveCatastral', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'regimenPropiedad', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'fechaAdquicision', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'titularAnterior', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'documentoPropiedad', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'folio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'fechaDocumento', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'loteConflicto', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'observaciones', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'colonia', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'municipio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'calle', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'numeroExterior', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'numeroInterior', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'tipo', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'estastus', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'ultimoEjercicioPagado', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'ultimoPeriodoPagado', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'cvePredio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'createdAt', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'updatedAt', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'idContribuyente'];
        }

        return ['__isInitialized__', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'idPredio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'parcela', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'manzana', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'lote', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'local', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'categoria', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'condicion', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'titular', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'ubicacion', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'localidad', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'antecedentes', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'claveCatastral', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'regimenPropiedad', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'fechaAdquicision', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'titularAnterior', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'documentoPropiedad', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'folio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'fechaDocumento', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'loteConflicto', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'observaciones', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'colonia', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'municipio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'calle', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'numeroExterior', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'numeroInterior', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'tipo', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'estastus', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'ultimoEjercicioPagado', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'ultimoPeriodoPagado', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'cvePredio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'createdAt', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'updatedAt', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'idContribuyente'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Predio $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy::$lazyPropertiesDefaults as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @deprecated no longer in use - generated code now relies on internal components rather than generated public API
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getIdPredio()
    {
        if ($this->__isInitialized__ === false) {
            return  parent::getIdPredio();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdPredio', []);

        return parent::getIdPredio();
    }

    /**
     * {@inheritDoc}
     */
    public function setParcela($parcela = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParcela', [$parcela]);

        return parent::setParcela($parcela);
    }

    /**
     * {@inheritDoc}
     */
    public function getParcela()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParcela', []);

        return parent::getParcela();
    }

    /**
     * {@inheritDoc}
     */
    public function setManzana($manzana = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setManzana', [$manzana]);

        return parent::setManzana($manzana);
    }

    /**
     * {@inheritDoc}
     */
    public function getManzana()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getManzana', []);

        return parent::getManzana();
    }

    /**
     * {@inheritDoc}
     */
    public function setLote($lote = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLote', [$lote]);

        return parent::setLote($lote);
    }

    /**
     * {@inheritDoc}
     */
    public function getLote()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLote', []);

        return parent::getLote();
    }

    /**
     * {@inheritDoc}
     */
    public function setLocal($local = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLocal', [$local]);

        return parent::setLocal($local);
    }

    /**
     * {@inheritDoc}
     */
    public function getLocal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLocal', []);

        return parent::getLocal();
    }

    /**
     * {@inheritDoc}
     */
    public function setCategoria($categoria = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCategoria', [$categoria]);

        return parent::setCategoria($categoria);
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoria()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCategoria', []);

        return parent::getCategoria();
    }

    /**
     * {@inheritDoc}
     */
    public function setCondicion($condicion = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCondicion', [$condicion]);

        return parent::setCondicion($condicion);
    }

    /**
     * {@inheritDoc}
     */
    public function getCondicion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCondicion', []);

        return parent::getCondicion();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitular($titular = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitular', [$titular]);

        return parent::setTitular($titular);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitular()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitular', []);

        return parent::getTitular();
    }

    /**
     * {@inheritDoc}
     */
    public function setUbicacion($ubicacion = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUbicacion', [$ubicacion]);

        return parent::setUbicacion($ubicacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getUbicacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUbicacion', []);

        return parent::getUbicacion();
    }

    /**
     * {@inheritDoc}
     */
    public function setLocalidad($localidad = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLocalidad', [$localidad]);

        return parent::setLocalidad($localidad);
    }

    /**
     * {@inheritDoc}
     */
    public function getLocalidad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLocalidad', []);

        return parent::getLocalidad();
    }

    /**
     * {@inheritDoc}
     */
    public function setAntecedentes($antecedentes = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAntecedentes', [$antecedentes]);

        return parent::setAntecedentes($antecedentes);
    }

    /**
     * {@inheritDoc}
     */
    public function getAntecedentes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAntecedentes', []);

        return parent::getAntecedentes();
    }

    /**
     * {@inheritDoc}
     */
    public function setClaveCatastral($claveCatastral = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClaveCatastral', [$claveCatastral]);

        return parent::setClaveCatastral($claveCatastral);
    }

    /**
     * {@inheritDoc}
     */
    public function getClaveCatastral()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClaveCatastral', []);

        return parent::getClaveCatastral();
    }

    /**
     * {@inheritDoc}
     */
    public function setRegimenPropiedad($regimenPropiedad = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRegimenPropiedad', [$regimenPropiedad]);

        return parent::setRegimenPropiedad($regimenPropiedad);
    }

    /**
     * {@inheritDoc}
     */
    public function getRegimenPropiedad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRegimenPropiedad', []);

        return parent::getRegimenPropiedad();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechaAdquicision($fechaAdquicision = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechaAdquicision', [$fechaAdquicision]);

        return parent::setFechaAdquicision($fechaAdquicision);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaAdquicision()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaAdquicision', []);

        return parent::getFechaAdquicision();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitularAnterior($titularAnterior = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitularAnterior', [$titularAnterior]);

        return parent::setTitularAnterior($titularAnterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitularAnterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitularAnterior', []);

        return parent::getTitularAnterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setDocumentoPropiedad($documentoPropiedad = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDocumentoPropiedad', [$documentoPropiedad]);

        return parent::setDocumentoPropiedad($documentoPropiedad);
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentoPropiedad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDocumentoPropiedad', []);

        return parent::getDocumentoPropiedad();
    }

    /**
     * {@inheritDoc}
     */
    public function setFolio($folio = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFolio', [$folio]);

        return parent::setFolio($folio);
    }

    /**
     * {@inheritDoc}
     */
    public function getFolio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFolio', []);

        return parent::getFolio();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechaDocumento($fechaDocumento = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechaDocumento', [$fechaDocumento]);

        return parent::setFechaDocumento($fechaDocumento);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaDocumento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaDocumento', []);

        return parent::getFechaDocumento();
    }

    /**
     * {@inheritDoc}
     */
    public function setLoteConflicto($loteConflicto = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLoteConflicto', [$loteConflicto]);

        return parent::setLoteConflicto($loteConflicto);
    }

    /**
     * {@inheritDoc}
     */
    public function getLoteConflicto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLoteConflicto', []);

        return parent::getLoteConflicto();
    }

    /**
     * {@inheritDoc}
     */
    public function setObservaciones($observaciones = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setObservaciones', [$observaciones]);

        return parent::setObservaciones($observaciones);
    }

    /**
     * {@inheritDoc}
     */
    public function getObservaciones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObservaciones', []);

        return parent::getObservaciones();
    }

    /**
     * {@inheritDoc}
     */
    public function setColonia($colonia = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setColonia', [$colonia]);

        return parent::setColonia($colonia);
    }

    /**
     * {@inheritDoc}
     */
    public function getColonia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getColonia', []);

        return parent::getColonia();
    }

    /**
     * {@inheritDoc}
     */
    public function setMunicipio($municipio = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMunicipio', [$municipio]);

        return parent::setMunicipio($municipio);
    }

    /**
     * {@inheritDoc}
     */
    public function getMunicipio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMunicipio', []);

        return parent::getMunicipio();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalle($calle = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalle', [$calle]);

        return parent::setCalle($calle);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalle', []);

        return parent::getCalle();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumeroExterior($numeroExterior = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumeroExterior', [$numeroExterior]);

        return parent::setNumeroExterior($numeroExterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumeroExterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumeroExterior', []);

        return parent::getNumeroExterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumeroInterior($numeroInterior = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumeroInterior', [$numeroInterior]);

        return parent::setNumeroInterior($numeroInterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumeroInterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumeroInterior', []);

        return parent::getNumeroInterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipo($tipo = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipo', [$tipo]);

        return parent::setTipo($tipo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipo', []);

        return parent::getTipo();
    }

    /**
     * {@inheritDoc}
     */
    public function setEstastus($estastus = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstastus', [$estastus]);

        return parent::setEstastus($estastus);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstastus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstastus', []);

        return parent::getEstastus();
    }

    /**
     * {@inheritDoc}
     */
    public function setUltimoEjercicioPagado($ultimoEjercicioPagado = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUltimoEjercicioPagado', [$ultimoEjercicioPagado]);

        return parent::setUltimoEjercicioPagado($ultimoEjercicioPagado);
    }

    /**
     * {@inheritDoc}
     */
    public function getUltimoEjercicioPagado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUltimoEjercicioPagado', []);

        return parent::getUltimoEjercicioPagado();
    }

    /**
     * {@inheritDoc}
     */
    public function setUltimoPeriodoPagado($ultimoPeriodoPagado = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUltimoPeriodoPagado', [$ultimoPeriodoPagado]);

        return parent::setUltimoPeriodoPagado($ultimoPeriodoPagado);
    }

    /**
     * {@inheritDoc}
     */
    public function getUltimoPeriodoPagado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUltimoPeriodoPagado', []);

        return parent::getUltimoPeriodoPagado();
    }

    /**
     * {@inheritDoc}
     */
    public function setCvePredio($cvePredio = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCvePredio', [$cvePredio]);

        return parent::setCvePredio($cvePredio);
    }

    /**
     * {@inheritDoc}
     */
    public function getCvePredio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCvePredio', []);

        return parent::getCvePredio();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt($createdAt = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedAt', [$createdAt]);

        return parent::setCreatedAt($createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAt', []);

        return parent::getCreatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt($updatedAt = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAt', [$updatedAt]);

        return parent::setUpdatedAt($updatedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', []);

        return parent::getUpdatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdContribuyente(\Catastro\Entity\Contribuyente $idContribuyente = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdContribuyente', [$idContribuyente]);

        return parent::setIdContribuyente($idContribuyente);
    }

    /**
     * {@inheritDoc}
     */
    public function getIdContribuyente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdContribuyente', []);

        return parent::getIdContribuyente();
    }

}
