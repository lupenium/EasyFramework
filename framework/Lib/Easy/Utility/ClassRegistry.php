<?php

App::uses('Model', 'Model');

/**
 *  ClassRegistry faz o registro e gerenciamento de instâncias das classes utilizadas
 *  pelo EasyFramework, evitando a criação de várias instâncias de uma mesma classe.
 *
 *  @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 *  @copyright Copyright 2011, EasyFramework (http://www.easy.lellysinformatica.com)
 *
 */
class ClassRegistry
{

    /**
     *  Nome das classes a serem utilizados pelo EasyFramework
     */
    public $objects = array();

    /**
     * Names of class names mapped to the object in the registry.
     *
     * @var array
     */
    protected $_map = array();

    /**
     * Singleton instance
     *
     * Marked only as protected to allow extension of the class. To extend,
     * simply override {@link getInstance()}.
     *
     * @var ClassRegistry
     */
    protected static $instance;

    /**
     * Singleton instance
     *
     * @return ClassRegistry
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *  Carrega a classe, registrando o objeto, retornando uma instância
     *  para a mesma.
     *
     *  @param string $class Classe a ser inicializada
     *  @param string $type Tipo da classe
     *  @return object Instância da classe
     */
    public static function &load($class, $type = "Model")
    {
        $_this = self::getInstance();
        $object = & $_this->duplicate($class, $class);
        if ($object) {
            return $object;
        } elseif (!class_exists($class)) {
            App::uses($class, $type);
        }
        if (class_exists($class)) {
            ${$class} = new $class;
        }
        return ${$class};
    }

    /**
     * Add $object to the registry, associating it with the name $key.
     *
     * @param string $key	Key for the object in registry
     * @param mixed $object	Object to store
     * @return boolean True if the object was written, false if $key already exists
     */
    public static function addObject($key, $object)
    {
        $_this = self::getInstance();
        $key = Inflector::underscore($key);
        if (!isset($_this->objects[$key])) {
            $_this->objects[$key] = $object;
            return true;
        }
        return false;
    }

    /**
     * Remove object which corresponds to given key.
     *
     * @param string $key	Key of object to remove from registry
     * @return void
     */
    public static function removeObject($key)
    {
        $_this = self::getInstance();
        $key = Inflector::underscore($key);
        if (isset($_this->objects[$key])) {
            unset($_this->objects[$key]);
        }
    }

    /**
     * Returns true if given key is present in the ClassRegistry.
     *
     * @param string $key Key to look for
     * @return boolean true if key exists in registry, false otherwise
     */
    public static function isKeySet($key)
    {
        $_this = self::getInstance();
        $key = Inflector::underscore($key);
        if (isset($_this->objects[$key])) {
            return true;
        } elseif (isset($_this->_map[$key])) {
            return true;
        }
        return false;
    }

    /**
     * Get all keys from the registry.
     *
     * @return array Set of keys stored in registry
     */
    public static function keys()
    {
        $_this = self::getInstance();
        return array_keys($_this->objects);
    }

    /**
     * Return object which corresponds to given key.
     *
     * @param string $key Key of object to look for
     * @return mixed Object stored in registry or boolean false if the object does not exist.
     */
    public static function &getObject($key)
    {
        $_this = self::getInstance();
        $key = Inflector::underscore($key);
        $return = false;
        if (isset($_this->objects[$key])) {
            $return = $_this->objects[$key];
        } else {
            $key = $_this->_getMap($key);
            if (isset($_this->objects[$key])) {
                $return = $_this->objects[$key];
            }
        }
        return $return;
    }

    /**
     *  Retorna uma cópia de uma instância já registrada.
     * 
     *  @param string $key
     *  @param object $class
     *  @return mixed
     */
    public static function &duplicate($key, $class)
    {
        $self = self::getInstance();
        $duplicate = false;
        if (self::isKeySet($key)):
            $object = & self::getObject($key);
            if ($object instanceof $class):
                $duplicate = & $object;
            endif;
            unset($object);
        endif;
        return $duplicate;
    }

    /**
     * Get all keys from the map in the registry.
     *
     * @return array Keys of registry's map
     */
    public static function mapKeys()
    {
        $_this = self::getInstance();
        return array_keys($_this->_map);
    }

    /**
     * Return the name of a class in the registry.
     *
     * @param string $key Key to find in map
     * @return string Mapped value
     */
    protected function _getMap($key)
    {
        if (isset($this->_map[$key])) {
            return $this->_map[$key];
        }
    }

    /**
     * Flushes all objects from the ClassRegistry.
     *
     * @return void
     */
    public static function flush()
    {
        $_this = self::getInstance();
        $_this->objects = array();
        $_this->_map = array();
    }

}

?>