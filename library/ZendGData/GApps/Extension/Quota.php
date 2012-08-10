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
 * Represents the apps:quota element used by the Apps data API. This is
 * used to indicate the amount of storage space available to a user. Quotas
 * may not be able to be set, depending on the domain used. This class
 * is usually contained within an instance of ZendGData\GApps\UserEntry.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GApps
 */
class Quota extends \ZendGData\Extension
{

    protected $_rootNamespace = 'apps';
    protected $_rootElement = 'quota';

    /**
     * The amount of storage space available to the user in megabytes.
     *
     * @var integer
     */
    protected $_limit = null;

    /**
     * Constructs a new ZendGData\GApps\Extension\Quota object.
     *
     * @param string $limit (optional) The limit, in bytes, for this quota.
     */
    public function __construct($limit = null)
    {
        $this->registerAllNamespaces(\ZendGData\GApps::$namespaces);
        parent::__construct();
        $this->_limit = $limit;
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
        if ($this->_limit !== null) {
            $element->setAttribute('limit', $this->_limit);
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
        case 'limit':
            $this->_limit = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * Get the value for this element's limit attribute.
     *
     * @see setLimit
     * @return string The requested attribute.
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * Set the value for this element's limit attribute. This is the amount
     * of storage space, in bytes, that should be made available to
     * the associated user.
     *
     * @param string $value The desired value for this attribute.
     * @return \ZendGData\GApps\Extension\Quota Provides a fluent interface.
     */
    public function setLimit($value)
    {
        $this->_limit = $value;
        return $this;
    }

    /**
     * Magic toString method allows using this directly via echo
     * Works best in PHP >= 4.2.0
     */
    public function __toString()
    {
        return $this->getLimit();
    }

}
