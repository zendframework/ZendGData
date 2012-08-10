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
 * User-provided review
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Books
 */
class Review extends \ZendGData\Extension
{

    protected $_rootNamespace = 'gbs';
    protected $_rootElement = 'review';
    protected $_lang = null;
    protected $_type = null;

    /**
     * Constructor for ZendGData\Books\Extension\Review which
     * User-provided review
     *
     * @param string|null $lang Review language.
     * @param string|null $type Type of text construct (typically text, html,
     *        or xhtml).
     * @param string|null $value Text content of the review.
     */
    public function __construct($lang = null, $type = null, $value = null)
    {
        $this->registerAllNamespaces(\ZendGData\Books::$namespaces);
        parent::__construct();
        $this->_lang = $lang;
        $this->_type = $type;
        $this->_text = $value;
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
        if ($this->_lang !== null) {
            $element->setAttribute('lang', $this->_lang);
        }
        if ($this->_type !== null) {
            $element->setAttribute('type', $this->_type);
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
        case 'lang':
            $this->_lang = $attribute->nodeValue;
            break;
        case 'type':
            $this->_type = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * Returns the language of link title
     *
     * @return string The lang
     */
    public function getLang()
    {
        return $this->_lang;
    }

    /**
     * Returns the type of text construct (typically 'text', 'html' or 'xhtml')
     *
     * @return string The type
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Sets the language of link title
     *
     * @param string $lang language of link title
     * @return \ZendGData\Books\Extension\Review Provides a fluent interface
     */
    public function setLang($lang)
    {
        $this->_lang = $lang;
        return $this;
    }

    /**
     * Sets the type of text construct (typically 'text', 'html' or 'xhtml')
     *
     * @param string $type type of text construct (typically 'text', 'html' or 'xhtml')
     * @return \ZendGData\Books\Extension\Review Provides a fluent interface
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }


}

