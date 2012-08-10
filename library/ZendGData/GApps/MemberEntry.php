<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\GApps;

use ZendGData\GApps;

/**
 * Data model class for a Google Apps Member Entry.
 *
 * Each member entry describes a single member within a Google Apps hosted
 * domain.
 *
 * To transfer member entries to and from the Google Apps servers, including
 * creating new entries, refer to the Google Apps service class,
 * ZendGData\GApps.
 *
 * This class represents <atom:entry> in the Google Data protocol.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GApps
 */
class MemberEntry extends \ZendGData\Entry
{

    protected $_entryClassName = '\ZendGData\GApps\MemberEntry';

    /**
     * <apps:property> element containing information about other items
     * relevant to this entry.
     *
     * @var Extension\Property
     */
    protected $_property = array();

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(\ZendGData\GApps::$namespaces);
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

        foreach ($this->_property as $p) {
            $element->appendChild($p->getDOM($element->ownerDocument));
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

            case $this->lookupNamespace('apps') . ':' . 'property';
                $property = new Extension\Property();
                $property->transferFromDOM($child);
                $this->_property[] = $property;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    /**
     * Returns all property tags for this entry
     *
     * @param string $rel The rel value of the property to be found. If null,
     *          the array of properties is returned instead.
     * @return mixed Either an array of \ZendGData\GApps\Extension\Property
     *          objects if $rel is null, a single
     *          \ZendGData\GApps\Extension\Property object if $rel is specified
     *          and a matching feed link is found, or null if $rel is
     *          specified and no matching property is found.
     */
    public function getProperty($rel = null)
    {
        if ($rel == null) {
            return $this->_property;
        } else {
            foreach ($this->_property as $p) {
                if ($p->rel == $rel) {
                    return $p;
                }
            }
            return null;
        }
    }

    /**
     * Set the value of the  property property for this object.
     *
     * @param array $value A collection of
     *          \ZendGData\GApps\Extension\Property objects.
     * @return MemberEntry Provides a fluent interface.
     */
    public function setProperty($value)
    {
        $this->_property = $value;
        return $this;
    }

}
