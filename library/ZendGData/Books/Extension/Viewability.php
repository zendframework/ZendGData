<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Books\Extension;

/**
 * Describes a viewability
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Books
 */
class Viewability extends \ZendGData\Extension
{

    protected $_rootNamespace = 'gbs';
    protected $_rootElement = 'viewability';
    protected $_value = null;

    /**
     * Constructor for ZendGData\Books\Extension\Viewability which
     * Describes a viewability
     *
     * @param string|null $value A programmatic value representing the book's
     *        viewability mode.
     */
    public function __construct($value = null)
    {
        $this->registerAllNamespaces(\ZendGData\Books::$namespaces);
        parent::__construct();
        $this->_value = $value;
    }

    /**
     * Retrieves DOMElement which corresponds to this element and all
     * child properties. This is used to build this object back into a DOM
     * and eventually XML text for sending to the server upon updates, or
     * for application storage/persistance.
     *
     * @param DOMDocument $doc The DOMDocument used to construct DOMElements
     * @return DOMElement The DOMElement representing this element and all
     * child properties.
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc);
        if ($this->_value !== null) {
            $element->setAttribute('value', $this->_value);
        }
        return $element;
    }

    /**
     * Extracts XML attributes from the DOM and converts them to the
     * appropriate object members.
     *
     * @param DOMNode $attribute The DOMNode attribute to be handled.
     */
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'value':
            $this->_value = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * Returns the programmatic value that describes the viewability of a volume
     * in Google Book Search
     *
     * @return string The value
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Sets the programmatic value that describes the viewability of a volume in
     * Google Book Search
     *
     * @param string $value programmatic value that describes the viewability
     *     of a volume in Googl eBook Search
     * @return \ZendGData\Books\Extension\Viewability Provides a fluent
     *     interface
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }


}

