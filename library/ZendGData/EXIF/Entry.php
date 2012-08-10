<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\EXIF;

use ZendGData\EXIF;

/**
 * An Atom entry containing EXIF metadata.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage EXIF
 */
class Entry extends \ZendGData\Entry
{
    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = '\ZendGData\EXIF\Entry';

    /**
     * The tags that belong to the EXIF group.
     *
     * @var string
     */
    protected $_tags = null;

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(EXIF::$namespaces);
        parent::__construct($element);
    }

    /**
     * Retrieves a DOMElement which corresponds to this element and all
     * child properties.  This is used to build an entry back into a DOM
     * and eventually XML text for sending to the server upon updates, or
     * for application storage/persistence.
     *
     * @param DOMDocument $doc The DOMDocument used to construct DOMElements
     * @return DOMElement The DOMElement representing this element and all
     * child properties.
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_tags != null) {
            $element->appendChild($this->_tags->getDOM($element->ownerDocument));
        }
        return $element;
    }

    /**
     * Creates individual Entry objects of the appropriate type and
     * stores them as members of this entry based upon DOM data.
     *
     * @param DOMNode $child The DOMNode to process
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('exif') . ':' . 'tags':
            $tags = new Extension\Tags();
            $tags->transferFromDOM($child);
            $this->_tags = $tags;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Retrieve the tags for this entry.
     *
     * @see setTags
     * @return \ZendGData\EXIF\Extension\Tags The requested object
     *              or null if not set.
     */
    public function getTags()
    {
        return $this->_tags;
    }

    /**
     * Set the tags property for this entry. This property contains
     * various EXIF data.
     *
     * This corresponds to the <exif:tags> property in the Google Data
     * protocol.
     *
     * @param \ZendGData\EXIF\Extension\Tags $value The desired value
     *              this element, or null to unset.
     * @return \ZendGData\EXIF\Entry Provides a fluent interface
     */
    public function setTags($value)
    {
        $this->_tags = $value;
        return $this;
    }

}
