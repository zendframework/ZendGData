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
 * Topic of the resource
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage DublinCore
 */
class Subject extends \ZendGData\Extension
{

    protected $_rootNamespace = 'dc';
    protected $_rootElement = 'subject';

    /**
     * Constructor for ZendGData\DublinCore\Extension\Subject which
     * Topic of the resource
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
