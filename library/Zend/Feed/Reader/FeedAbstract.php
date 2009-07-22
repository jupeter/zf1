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
 * @category   Zend
 * @package    Zend_Feed_Reader
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @see Zend_Feed_Reader
 */
require_once 'Zend/Feed/Reader.php';

/**
 * @see Zend_Feed_Reader_Entry_Atom
 */
require_once 'Zend/Feed/Reader/Entry/Atom.php';


/**
 * @see Zend_Feed_Reader_Entry_Rss
 */
require_once 'Zend/Feed/Reader/Entry/Rss.php';

/**
 * @see Zend_feed_Reader_FeedInterface
 */
require_once 'Zend/Feed/Reader/FeedInterface.php';

/**
 * @category   Zend
 * @package    Zend_Feed_Reader
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Feed_Reader_FeedAbstract implements Zend_Feed_Reader_FeedInterface
{
	/**
     * Parsed feed data
     *
     * @var array
     */
    protected $_data = array();

    /**
     * Parsed feed data in the shape of a DOMDocument
     *
     * @var DOMDocument
     */
    protected $_domDocument = null;

    /**
     * An array of parsed feed entries
     *
     * @var array
     */
    protected $_entries = array();

    /**
     * A pointer for the iterator to keep track of the entries array
     *
     * @var int
     */
    protected $_entriesKey = 0;

    /**
     * The base XPath query used to retrieve feed data
     *
     * @var DOMXPath
     */
    protected $_xpath = null;

    protected $_extensions = array();

    /**
     * Constructor
     *
     * @param DomDocument The DOM object for the feed's XML
     * @param string $type Feed type
     */
    public function __construct(DomDocument $domDocument, $type = null)
    {
        $this->_domDocument = $domDocument;
        $this->_xpath = new DOMXPath($this->_domDocument);

        if ($type !== null) {
            $this->_data['type'] = $type;
        } else {
            $this->_data['type'] = Zend_Feed_Reader::detectType($this->_domDocument);
        }
        $this->_registerNamespaces();
        $this->_indexEntries();
        $this->_loadExtensions();
    }

	/**
     * Get the number of feed entries.
     * Required by the Iterator interface.
     *
     * @return int
     */
    public function count()
    {
        return count($this->_entries);
    }

	/**
     * Return the current entry
     *
     * @return Zend_Feed_Reader_Entry_Interface
     */
    public function current()
    {
        if (substr($this->getType(), 0, 3) == 'rss') {
            $reader = new Zend_Feed_Reader_Entry_Rss($this->_entries[$this->key()], $this->key(), $this->getType());
        } else {
            $reader = new Zend_Feed_Reader_Entry_Atom($this->_entries[$this->key()], $this->key(), $this->getType());
        }

        $reader->setXpath($this->_xpath);

        return $reader;
    }

    /**
     * Get the DOM
     *
     * @return DOMDocument
     */
    public function getDomDocument()
    {
        return $this->_domDocument;
    }

    /**
     * Get the Feed's encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        $assumed = $this->getDomDocument()->encoding;
        return $assumed;
    }

    /**
     * Get feed as xml
     *
     * @return string
     */
    public function saveXml()
    {
          return $this->getDomDocument()->saveXml();
    }

    /**
     * Get the DOMElement representing the items/feed element
     *
     * @return DOMElement
     */
    public function getElement()
    {
          return $this->getDomDocument()->documentElement;
    }

    /**
     * Get the DOMXPath object for this feed
     *
     * @return DOMXPath
     */
    public function getXpath()
    {
          return $this->_xpath;
    }

    /**
     * Get the feed type
     *
     * @return string
     */
    public function getType()
    {
        return $this->_data['type'];
    }

	/**
     * Return the current feed key
     *
     * @return unknown
     */
    public function key()
    {
        return $this->_entriesKey;
    }

	/**
     * Move the feed pointer forward
     *
     */
    public function next()
    {
        ++$this->_entriesKey;
    }

    /**
     * Reset the pointer in the feed object
     *
     */
    public function rewind()
    {
        $this->_entriesKey = 0;
    }

    /**
     * Return the feed as an array
     *
     * @return array
     */
    public function toArray() // untested
    {
        return $this->_data;
    }

    /**
     * Check to see if the iterator is still valid
     *
     * @return boolean
     */
    public function valid()
    {
        return 0 <= $this->_entriesKey && $this->_entriesKey < $this->count();
    }

    public function getExtensions()
    {
        return $this->_extensions;
    }

    public function __call($method, $args)
    {
        foreach ($this->_extensions as $extension) {
            if (method_exists($extension, $method)) {
                return call_user_func_array(array($extension, $method), $args);
            }
        }
        require_once 'Zend/Feed/Exception.php';
        throw new Zend_Feed_Exception('Method: ' . $method
        . 'does not exist and could not be located on a registered Extension');
    }

    protected function _loadExtensions()
    {
        $all = Zend_Feed_Reader::getExtensions();
        $feed = $all['feed'];
        foreach ($feed as $extension) {
            if (in_array($extension, $all['core'])) {
                continue;
            }
            $className = Zend_Feed_Reader::getPluginLoader()->getClassName($extension);
            $this->_extensions[$className] = new $className(
                $this->getDomDocument(), $this->_data['type'], $this->_xpath
            );
        }
    }

    /**
     * Read all entries to the internal entries array
     *
     */
    abstract protected function _indexEntries();

    /**
     * Register the default namespaces for the current feed format
     *
     */
    abstract protected function _registerNamespaces();
}