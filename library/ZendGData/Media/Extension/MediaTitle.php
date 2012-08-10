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
 * Represents the media:title element in MediaRSS
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Media
 */
class MediaTitle extends \ZendGData\Extension
{

    protected $_rootElement = 'title';
    protected $_rootNamespace = 'media';

    /**
     * @var string
     */
    protected $_type = null;

    /**
     * Constructs a MediaTitle element
     *
     * @param string $text
     * @param string $type
     */
    public function __construct($text = null, $type = null)
    {
        $this->registerAllNamespaces(\ZendGData\Media::$namespaces);
        parent::__construct();
        $this->_type = $type;
        $this->_text = $text;
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
        if ($this->_type !== null) {
            $element->setAttribute('type', $this->_type);
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
        case 'type':
            $this->_type = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param string $value
     * @return \ZendGData\Media\Extension\MediaTitle Provides a fluent interface
     */
    public function setType($value)
    {
        $this->_type = $value;
        return $this;
    }

}
