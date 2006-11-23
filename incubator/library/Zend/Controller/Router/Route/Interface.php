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
 * @package    Zend_Controller
 * @subpackage Router
 * @copyright  Copyright (c) 2005-2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @version    $Id$
 * @license    http://www.zend.com/license/framework/1_0.txt Zend Framework License version 1.0
 */


/** Zend_Controller_Router_Exception */
require_once 'Zend/Controller/Router/Exception.php';


/**
 * @package    Zend_Controller
 * @subpackage Router
 * @copyright  Copyright (c) 2005-2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://www.zend.com/license/framework/1_0.txt Zend Framework License version 1.0
 */
interface Zend_Controller_Router_Route_Interface {
    public function __construct($route, $defaults = array(), $reqs = array());
    public function match($path);
    public function assemble($data = array());
}

