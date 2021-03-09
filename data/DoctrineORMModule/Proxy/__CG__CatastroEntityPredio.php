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
            return ['__isInitialized__', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'idPredio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'claveCatastral', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'ubicacion', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'titular', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'titularAnterior', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'createdAt', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'updatedAt', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'idContribuyente'];
        }

        return ['__isInitialized__', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'idPredio', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'claveCatastral', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'ubicacion', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'titular', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'titularAnterior', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'createdAt', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'updatedAt', '' . "\0" . 'Catastro\\Entity\\Predio' . "\0" . 'idContribuyente'];
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
