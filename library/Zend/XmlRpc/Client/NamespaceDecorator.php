<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @package    Zend_XmlRpc
 * @subpackage Client
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */


/**
 * The namespace decorator enables object chaining to permit
 * calling XML-RPC namespaced functions like "foo.bar.baz()"
 * as "$remote->foo->bar->baz()".
 *
 * @package    Zend_XmlRpc
 * @subpackage Client
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_XmlRpc_Client_NamespaceDecorator
{
    /**
     * @var Zend_XmlRpc_Client
     */
    protected $_client = null;

    /**
     * XML-RPC namespace for this decorator
     * @var string
     */
    protected $_namespace = '';
    
    /**
     * Cached namespace decorators
     * @var array 
     */
    protected $_cache = array();

    
    /**
     * Class constructor
     *
     * @param string             $namespace
     * @param Zend_XmlRpc_Client $client
     */
    public function __construct($namespace, Zend_XmlRpc_Client $client)
    {
        $this->_namespace = $namespace;
        $this->_client    = $client;
    }

    
    /**
     * Get the next successive namespace
     *
     * @param string $name
     * @return Zend_XmlRpc_Client_NamespaceDecorator
     */
    public function __get($name)
    {
        if (!isset($this->_cache[$name])) {
            $this->_cache[$name] = new $this("$this->_namespace.$name", 
                                             $this->_client);
        }
        
        return $this->_cache[$name];
    }

    
    /**
     * Call a method in this namespace.
     *
     * @param  string $methodName
     * @param  array $args
     * @return mixed
     */
    public function __call($methodName, $args)
    {
        return $this->_client->__call("$this->_namespace.$methodName", $args);
    }
}