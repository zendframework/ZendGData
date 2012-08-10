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
 * Represents the apps:emailList element used by the Apps data API. This
 * class represents properties of an email list and is usually contained
 * within an instance of ZendGData\GApps\EmailListEntry.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GApps
 */
class EmailList extends \ZendGData\Extension
{

    protected $_rootNamespace = 'apps';
    protected $_rootElement = 'emailList';

    /**
     * The name of the email list. This name is used as the email address
     * for this list.
     *
     * @var string
     */
    protected $_name = null;

    /**
     * Constructs a new ZendGData\GApps\Extension\EmailList object.
     *
     * @param string $name (optional) The name to be used for this email list.
     */
    public function __construct($name = null)
    {
        $this->registerAllNamespaces(\ZendGData\GApps::$namespaces);
        parent::__construct();
        $this->_name = $name;
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
        if ($this->_name !== null) {
            $element->setAttribute('name', $this->_name);
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
        case 'name':
            $this->_name = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * Get the value for this element's name attribute.
     *
     * @see setName
     * @return string The requested attribute.
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the value for this element's name attribute. This is the unique
     * name which will be used to identify this email list within this
     * domain, and will be used to form this email list's email address.
     *
     * @param string $value The desired value for this attribute.
     * @return \ZendGData\GApps\Extension\EmailList The element being modified.
     */
    public function setName($value)
    {
        $this->_name = $value;
        return $this;
    }

    /**
     * Magic toString method allows using this directly via echo
     * Works best in PHP >= 4.2.0
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

}
