<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\GApps\Extension;

/**
 * Represents the apps:name element used by the Apps data API. This is used
 * to represent a user's full name. This class is usually contained within
 * instances of ZendGData\GApps\UserEntry.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GApps
 */
class Name extends \ZendGData\Extension
{

    protected $_rootNamespace = 'apps';
    protected $_rootElement = 'name';

    /**
     * The associated user's family name.
     *
     * @var string
     */
    protected $_familyName = null;

    /**
     * The associated user's given name.
     *
     * @var string
     */
    protected $_givenName = null;

    /**
     * Constructs a new ZendGData\GApps\Extension\Name object.
     *
     * @param string $familyName (optional) The familyName to be set for this
     *          object.
     * @param string $givenName (optional) The givenName to be set for this
     *          object.
     */
    public function __construct($familyName = null, $givenName = null)
    {
        $this->registerAllNamespaces(\ZendGData\GApps::$namespaces);
        parent::__construct();
        $this->_familyName = $familyName;
        $this->_givenName = $givenName;
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
        if ($this->_familyName !== null) {
            $element->setAttribute('familyName', $this->_familyName);
        }
        if ($this->_givenName !== null) {
            $element->setAttribute('givenName', $this->_givenName);
        }
        return $element;
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
        case 'familyName':
            $this->_familyName = $attribute->nodeValue;
            break;
        case 'givenName':
            $this->_givenName = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * Get the value for this element's familyName attribute.
     *
     * @see setFamilyName
     * @return string The requested attribute.
     */
    public function getFamilyName()
    {
        return $this->_familyName;
    }

    /**
     * Set the value for this element's familyName attribute. This
     * represents a user's family name.
     *
     * @param string $value The desired value for this attribute.
     * @return \ZendGData\GApps\Extension\Name Provides a fluent interface..
     */
    public function setFamilyName($value)
    {
        $this->_familyName = $value;
        return $this;
    }

    /**
     * Get the value for this element's givenName attribute.
     *
     * @see setGivenName
     * @return string The requested attribute.
     */
    public function getGivenName()
    {
        return $this->_givenName;
    }

    /**
     * Set the value for this element's givenName attribute. This
     * represents a user's given name.
     *
     * @param string $value The desired value for this attribute.
     * @return \ZendGData\GApps\Extension\Name Provides a fluent interface.
     */
    public function setGivenName($value)
    {
        $this->_givenName = $value;
        return $this;
    }

    /**
     * Magic toString method allows using this directly via echo
     * Works best in PHP >= 4.2.0
     */
    public function __toString()
    {
        return $this->getGivenName() . ' ' . $this->getFamilyName();
    }

}
