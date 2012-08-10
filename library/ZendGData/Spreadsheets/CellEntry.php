<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Spreadsheets;

use ZendGData\Spreadsheets;

/**
 * Concrete class for working with Cell entries.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Spreadsheets
 */
class CellEntry extends \ZendGData\Entry
{

    protected $_entryClassName = 'ZendGData\Spreadsheets\CellEntry';
    protected $_cell;

    /**
     * Constructs a new ZendGData\Spreadsheets\CellEntry object.
     * @param string $uri (optional)
     * @param DOMElement $element (optional) The DOMElement on which to base this object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Spreadsheets::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_cell != null) {
            $element->appendChild($this->_cell->getDOM($element->ownerDocument));
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('gs') . ':' . 'cell';
            $cell = new Extension\Cell();
            $cell->transferFromDOM($child);
            $this->_cell = $cell;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Gets the Cell element of this Cell Entry.
     * @return \ZendGData\Spreadsheets\Extension\Cell
     */
    public function getCell()
    {
        return $this->_cell;
    }

    /**
     * Sets the Cell element of this Cell Entry.
     * @param $cell \ZendGData\Spreadsheets\Extension\Cell $cell
     */
    public function setCell($cell)
    {
        $this->_cell = $cell;
        return $this;
    }

}
