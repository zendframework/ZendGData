<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\YouTube\Extension;

/**
 * Represents the YouTube specific media:credit element
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Media
 */
class MediaCredit extends \ZendGData\Extension
{

    protected $_rootElement = 'credit';
    protected $_rootNamespace = 'media';

    /**
     * @var string
     */
    protected $_role = null;

    /**
     * @var string
     */
    protected $_scheme = null;

    /**
     * Represents the value of the yt:type attribute.
     *
     * Set to 'partner' if the uploader of this video is a YouTube
     * partner.
     *
     * @var string
     */
    protected $_yttype = null;

    /**
     * Creates an individual MediaCredit object.
     *
     * @param string $text
     * @param string $role
     * @param string $scheme
     */
    public function __construct($text = null, $role = null,  $scheme = null,
        $yttype = null)
    {
        $this->registerAllNamespaces(\ZendGData\Media::$namespaces);
        parent::__construct();
        $this->_text = $text;
        $this->_role = $role;
        $this->_scheme = $scheme;
        $this->_yttype = $yttype;
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
        if ($this->_role !== null) {
            $element->setAttribute('role', $this->_role);
        }
        if ($this->_scheme !== null) {
            $element->setAttribute('scheme', $this->_scheme);
        }
        if ($this->_yttype !== null) {
            $element->setAttributeNS('http://gdata.youtube.com/schemas/2007',
                'yt:type', $this->_yttype);
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
            case 'role':
                $this->_role = $attribute->nodeValue;
                break;
            case 'scheme':
                $this->_scheme = $attribute->nodeValue;
                break;
            case 'type':
                $this->_yttype = $attribute->nodeValue;
                break;
            default:
                parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * @param string $value
     * @return \ZendGData\Media\Extension\MediaCredit Provides a fluent
     *         interface
     */
    public function setRole($value)
    {
        $this->_role = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->_scheme;
    }

    /**
     * @param string $value
     * @return \ZendGData\Media\Extension\MediaCredit Provides a fluent
     *         interface
     */
    public function setScheme($value)
    {
        $this->_scheme = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getYTtype()
    {
        return $this->_yttype;
    }

    /**
     * @param string $value
     * @return \ZendGData\Media\Extension\MediaCredit Provides a fluent
     *         interface
     */
    public function setYTtype($value)
    {
        $this->_yttype = $value;
        return $this;
    }

}
