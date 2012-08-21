<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\DublinCore\Extension;

/**
 * Entity responsible for making the resource available
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage DublinCore
 */
class Publisher extends \ZendGData\Extension
{

    protected $_rootNamespace = 'dc';
    protected $_rootElement = 'publisher';

    /**
     * Constructor for ZendGData\DublinCore\Extension\Publisher which
     * Entity responsible for making the resource available
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($value = null)
    {
        $this->registerAllNamespaces(\ZendGData\DublinCore::$namespaces);
        parent::__construct();
        $this->_text = $value;
    }

}
