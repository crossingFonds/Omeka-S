<?php

namespace DoctrineProxies\__CG__\BulkImport\Entity;


/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Importer extends \BulkImport\Entity\Importer implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'id', 'owner', 'label', 'reader', 'mapper', 'processor', 'config', 'imports'];
        }

        return ['__isInitialized__', 'id', 'owner', 'label', 'reader', 'mapper', 'processor', 'config', 'imports'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Importer $proxy) {
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
    public function __load(): void
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized(): bool
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized): void
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null): void
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer(): ?\Closure
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null): void
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner(): ?\Closure
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @deprecated no longer in use - generated code now relies on internal components rather than generated public API
     * @static
     */
    public function __getLazyProperties(): array
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setOwner(\Omeka\Entity\User $owner = NULL): \BulkImport\Entity\Importer
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOwner', [$owner]);

        return parent::setOwner($owner);
    }

    /**
     * {@inheritDoc}
     */
    public function getOwner(): ?\Omeka\Entity\User
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOwner', []);

        return parent::getOwner();
    }

    /**
     * {@inheritDoc}
     */
    public function setLabel(string $label): \BulkImport\Entity\Importer
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLabel', [$label]);

        return parent::setLabel($label);
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLabel', []);

        return parent::getLabel();
    }

    /**
     * {@inheritDoc}
     */
    public function setReader(string $reader): \BulkImport\Entity\Importer
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReader', [$reader]);

        return parent::setReader($reader);
    }

    /**
     * {@inheritDoc}
     */
    public function getReader(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReader', []);

        return parent::getReader();
    }

    /**
     * {@inheritDoc}
     */
    public function setMapper(?string $mapper): \BulkImport\Entity\Importer
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMapper', [$mapper]);

        return parent::setMapper($mapper);
    }

    /**
     * {@inheritDoc}
     */
    public function getMapper(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMapper', []);

        return parent::getMapper();
    }

    /**
     * {@inheritDoc}
     */
    public function setProcessor(string $processor): \BulkImport\Entity\Importer
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProcessor', [$processor]);

        return parent::setProcessor($processor);
    }

    /**
     * {@inheritDoc}
     */
    public function getProcessor(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProcessor', []);

        return parent::getProcessor();
    }

    /**
     * {@inheritDoc}
     */
    public function setConfig(array $config): \BulkImport\Entity\Importer
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setConfig', [$config]);

        return parent::setConfig($config);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): array
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConfig', []);

        return parent::getConfig();
    }

    /**
     * {@inheritDoc}
     */
    public function getImports(): \Doctrine\Common\Collections\ArrayCollection
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImports', []);

        return parent::getImports();
    }

    /**
     * {@inheritDoc}
     */
    public function getResourceId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResourceId', []);

        return parent::getResourceId();
    }

}
