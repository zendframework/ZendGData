<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Media;

use ZendGData\Media;

/**
 * Represents the GData flavor of an Atom entry
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Media
 */
class Entry extends \ZendGData\Entry
{

    protected $_entryClassName = 'ZendGData\Media\Entry';

    /**
     * media:group element
     *
     * @var \ZendGData\Media\Extension\MediaGroup
     */
    protected $_mediaGroup = null;

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Media::$namespaces);
        parent::__construct($element);
    }

    /**
     * Retrieves a DOMElement which corresponds to this element and all
     * child properties.  This is used to build an entry back into a DOM
     * and eventually XML text for application storage/persistence.
     *
     * @param DOMDocument $doc The DOMDocument used to construct DOMElements
     * @return DOMElement The DOMElement representing this element and all
     *          child properties.
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_mediaGroup != null) {
            $element->appendChild($this->_mediaGroup->getDOM($element->ownerDocument));
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
        case $this->lookupNamespace('media') . ':' . 'group':
            $mediaGroup = new Extension\MediaGroup();
            $mediaGroup->transferFromDOM($child);
            $this->_mediaGroup = $mediaGroup;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Returns the entry's mediaGroup object.
     *
     * @return \ZendGData\Media\Extension\MediaGroup
    */
    public function getMediaGroup()
    {
        return $this->_mediaGroup;
    }

    /**
     * Sets the entry's mediaGroup object.
     *
     * @param \ZendGData\Media\Extension\MediaGroup $mediaGroup
     * @return \ZendGData\Media\Entry Provides a fluent interface
     */
    public function setMediaGroup($mediaGroup)
    {
        $this->_mediaGroup = $mediaGroup;
        return $this;
    }


}
