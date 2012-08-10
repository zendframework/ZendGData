<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Media\Extension;

/**
 * Represents the media:category element
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Media
 */
class MediaCategory extends \ZendGData\Extension
{

    protected $_rootElement = 'category';
    protected $_rootNamespace = 'media';

    /**
     * @var string
     */
    protected $_scheme = null;
    protected $_label = null;

    /**
     * Creates an individual MediaCategory object.
     *
     * @param string $text      Indication of the type and content of the media
     * @param string $scheme    URI that identifies the categorization scheme
     * @param string $label     Human-readable label to be displayed in applications
     */
    public function __construct($text = null, $scheme = null, $label = null)
    {
        $this->registerAllNamespaces(\ZendGData\Media::$namespaces);
        parent::__construct();
        $this->_text = $text;
        $this->_scheme = $scheme;
        $this->_label = $label;
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
        if ($this->_scheme !== null) {
            $element->setAttribute('scheme', $this->_scheme);
        }
        if ($this->_label !== null) {
            $element->setAttribute('label', $this->_label);
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
        case 'scheme':
            $this->_scheme = $attribute->nodeValue;
            break;
        case 'label':
            $this->_label = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * Returns the URI that identifies the categorization scheme
     * Optional.
     *
     * @return string URI that identifies the categorization scheme
     */
    public function getScheme()
    {
        return $this->_scheme;
    }

    /**
     * @param string $value     URI that identifies the categorization scheme
     * @return \ZendGData\Media\Extension\MediaCategory Provides a fluent interface
     */
    public function setScheme($value)
    {
        $this->_scheme = $value;
        return $this;
    }

    /**
     * @return string Human-readable label to be displayed in applications
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * @param string $value     Human-readable label to be displayed in applications
     * @return \ZendGData\Media\Extension\MediaCategory Provides a fluent interface
     */
    public function setLabel($value)
    {
        $this->_label = $value;
        return $this;
    }

}
