<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData;

use Zend\Http\Header\Etag;

/**
 * The GData flavor of an Atom Feed
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GData
 */
class Feed extends App\Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = '\ZendGData\Entry';

    /**
     * The openSearch:totalResults element
     *
     * @var \ZendGData\Extension\OpenSearchTotalResults|null
     */
    protected $_totalResults = null;

    /**
     * The openSearch:startIndex element
     *
     * @var \ZendGData\Extension\OpenSearchStartIndex|null
     */
    protected $_startIndex = null;

    /**
     * The openSearch:itemsPerPage element
     *
     * @var \ZendGData\Extension\OpenSearchItemsPerPage|null
     */
    protected $_itemsPerPage = null;

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(GData::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_totalResults != null) {
            $element->appendChild($this->_totalResults->getDOM($element->ownerDocument));
        }
        if ($this->_startIndex != null) {
            $element->appendChild($this->_startIndex->getDOM($element->ownerDocument));
        }
        if ($this->_itemsPerPage != null) {
            $element->appendChild($this->_itemsPerPage->getDOM($element->ownerDocument));
        }

        // ETags are special. We only support them in protocol >= 2.X.
        // This will be duplicated by the HTTP ETag header.
        if ($majorVersion >= 2) {
            if ($this->_etag != null) {
                $element->setAttributeNS($this->lookupNamespace('gd'),
                                         'gd:etag',
                                         $this->_etag->getFieldValue());
            }
        }

        return $element;
    }

    /**
     * Creates individual Entry objects of the appropriate type and
     * stores them in the $_entry array based upon DOM data.
     *
     * @param DOMNode $child The DOMNode to process
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('openSearch') . ':' . 'totalResults':
            $totalResults = new Extension\OpenSearchTotalResults();
            $totalResults->transferFromDOM($child);
            $this->_totalResults = $totalResults;
            break;
        case $this->lookupNamespace('openSearch') . ':' . 'startIndex':
            $startIndex = new Extension\OpenSearchStartIndex();
            $startIndex->transferFromDOM($child);
            $this->_startIndex = $startIndex;
            break;
        case $this->lookupNamespace('openSearch') . ':' . 'itemsPerPage':
            $itemsPerPage = new Extension\OpenSearchItemsPerPage();
            $itemsPerPage->transferFromDOM($child);
            $this->_itemsPerPage = $itemsPerPage;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Given a DOMNode representing an attribute, tries to map the data into
     * instance members.  If no mapping is defined, the name and value are
     * stored in an array.
     *
     * @param DOMNode $attribute The DOMNode attribute needed to be handled
     */
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'etag':
            // ETags are special, since they can be conveyed by either the
            // HTTP ETag header or as an XML attribute.
            $etag = $attribute->nodeValue;
            if (!($this->_etag instanceof Etag)) {
                $this->_etag = $etag;
            } elseif ($this->_etag->getFieldValue() != $etag) {
                throw new App\IOException("ETag mismatch");
            }
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
            break;
        }
    }

    /**
     *  Set the value of the totalResults property.
     *
     * @param \ZendGData\Extension\OpenSearchTotalResults|null $value The
     *        value of the totalResults property. Use null to unset.
     * @return \ZendGData\Feed Provides a fluent interface.
     */
    public function setTotalResults($value)
    {
        $this->_totalResults = $value;
        return $this;
    }

    /**
     * Get the value of the totalResults property.
     *
     * @return \ZendGData\Extension\OpenSearchTotalResults|null The value of
     *         the totalResults property, or null if unset.
     */
    public function getTotalResults()
    {
        return $this->_totalResults;
    }

    /**
     * Set the start index property for feed paging.
     *
     * @param \ZendGData\Extension\OpenSearchStartIndex|null $value The value
     *        for the startIndex property. Use null to unset.
     * @return \ZendGData\Feed Provides a fluent interface.
     */
    public function setStartIndex($value)
    {
        $this->_startIndex = $value;
        return $this;
    }

    /**
     * Get the value of the startIndex property.
     *
     * @return \ZendGData\Extension\OpenSearchStartIndex|null The value of the
     *         startIndex property, or null if unset.
     */
    public function getStartIndex()
    {
        return $this->_startIndex;
    }

    /**
     * Set the itemsPerPage property.
     *
     * @param \ZendGData\Extension\OpenSearchItemsPerPage|null $value The
     *        value for the itemsPerPage property. Use nul to unset.
     * @return \ZendGData\Feed Provides a fluent interface.
     */
    public function setItemsPerPage($value)
    {
        $this->_itemsPerPage = $value;
        return $this;
    }

    /**
     * Get the value of the itemsPerPage property.
     *
     * @return \ZendGData\Extension\OpenSearchItemsPerPage|null The value of
     *         the itemsPerPage property, or null if unset.
     */
    public function getItemsPerPage()
    {
        return $this->_itemsPerPage;
    }

}
