<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Spreadsheets\Extension;

/**
 * Concrete class for working with custom gsx elements.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Spreadsheets
 */
class Custom extends \ZendGData\Extension
{
    // custom elements have custom names.
    protected $_rootElement = null; // The name of the column
    protected $_rootNamespace = 'gsx';

    /**
     * Constructs a new ZendGData\Spreadsheets\Extension\Custom object.
     * @param string $column (optional) The column/tag name of the element.
     * @param string $value (optional) The text content of the element.
     */
    public function __construct($column = null, $value = null)
    {
        $this->registerAllNamespaces(\ZendGData\Spreadsheets::$namespaces);
        parent::__construct();
        $this->_text = $value;
        $this->_rootElement = $column;
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        return $element;
    }

    /**
     * Transfers each child and attribute into member variables.
     * This is called when XML is received over the wire and the data
     * model needs to be built to represent this XML.
     *
     * @param DOMNode $node The DOMNode that represents this object's data
     */
    public function transferFromDOM($node)
    {
        parent::transferFromDOM($node);
        $this->_rootElement = $node->localName;
    }

    /**
     * Sets the column/tag name of the element.
     * @param string $column The new column name.
     */
    public function setColumnName($column)
    {
        $this->_rootElement = $column;
        return $this;
    }

    /**
     * Gets the column name of the element
     * @return string The column name.
     */
    public function getColumnName()
    {
        return $this->_rootElement;
    }

}
