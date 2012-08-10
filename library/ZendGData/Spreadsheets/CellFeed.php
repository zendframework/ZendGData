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
 * @category   Zend
 * @package    ZendGData
 * @subpackage Spreadsheets
 */
class CellFeed extends \ZendGData\Feed
{

    /**
    * The classname for individual feed elements.
    *
    * @var string
    */
    protected $_entryClassName = 'ZendGData\Spreadsheets\CellEntry';

    /**
    * The classname for the feed.
    *
    * @var string
    */
    protected $_feedClassName = 'ZendGData\Spreadsheets\CellFeed';

    /**
    * The row count for the feed.
    *
    * @var \ZendGData\Spreadsheets\Extension\RowCount
    */
    protected $_rowCount = null;

    /**
    * The column count for the feed.
    *
    * @var \ZendGData\Spreadsheets\Extension\ColCount
    */
    protected $_colCount = null;

    /**
     * Constructs a new ZendGData\Spreadsheets\CellFeed object.
     * @param DOMElement $element (optional) The XML Element on which to base this object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Spreadsheets::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->rowCount != null) {
            $element->appendChild($this->_rowCount->getDOM($element->ownerDocument));
        }
        if ($this->colCount != null) {
            $element->appendChild($this->_colCount->getDOM($element->ownerDocument));
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
            case $this->lookupNamespace('gs') . ':' . 'rowCount';
                $rowCount = new Extension\RowCount();
                $rowCount->transferFromDOM($child);
                $this->_rowCount = $rowCount;
                break;
            case $this->lookupNamespace('gs') . ':' . 'colCount';
                $colCount = new Extension\ColCount();
                $colCount->transferFromDOM($child);
                $this->_colCount = $colCount;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    /**
     * Gets the row count for this feed.
     * @return string The row count for the feed.
     */
    public function getRowCount()
    {
        return $this->_rowCount;
    }

    /**
     * Gets the column count for this feed.
     * @return string The column count for the feed.
     */
    public function getColumnCount()
    {
        return $this->_colCount;
    }

    /**
     * Sets the row count for this feed.
     * @param string $rowCount The new row count for the feed.
     */
    public function setRowCount($rowCount)
    {
        $this->_rowCount = $rowCount;
        return $this;
    }

    /**
     * Sets the column count for this feed.
     * @param string $colCount The new column count for the feed.
     */
    public function setColumnCount($colCount)
    {
        $this->_colCount = $colCount;
        return $this;
    }

}
