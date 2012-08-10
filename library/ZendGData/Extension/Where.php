<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Extension;

use ZendGData\Extension;

/**
 * Data model class to represent a location (gd:where element)
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GData
 */
class Where extends Extension
{

    protected $_rootElement = 'where';
    protected $_label = null;
    protected $_rel = null;
    protected $_valueString = null;
    protected $_entryLink = null;

    public function __construct($valueString = null, $label = null, $rel = null, $entryLink = null)
    {
        parent::__construct();
        $this->_valueString = $valueString;
        $this->_label = $label;
        $this->_rel = $rel;
        $this->_entryLink = $entryLink;
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_label !== null) {
            $element->setAttribute('label', $this->_label);
        }
        if ($this->_rel !== null) {
            $element->setAttribute('rel', $this->_rel);
        }
        if ($this->_valueString !== null) {
            $element->setAttribute('valueString', $this->_valueString);
        }
        if ($this->entryLink !== null) {
            $element->appendChild($this->_entryLink->getDOM($element->ownerDocument));
        }
        return $element;
    }

    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'label':
            $this->_label = $attribute->nodeValue;
            break;
        case 'rel':
            $this->_rel = $attribute->nodeValue;
            break;
        case 'valueString':
            $this->_valueString = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * Creates individual Entry objects of the appropriate type and
     * stores them in the $_entry array based upon DOM data.
     *
     * @param DOMNode $child The DOMNode to process
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('gd') . ':' . 'entryLink':
            $entryLink = new EntryLink();
            $entryLink->transferFromDOM($child);
            $this->_entryLink = $entryLink;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    public function __toString()
    {
        if ($this->_valueString != null) {
            return $this->_valueString;
        } else {
            return parent::__toString();
        }
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel($value)
    {
        $this->_label = $value;
        return $this;
    }

    public function getRel()
    {
        return $this->_rel;
    }

    public function setRel($value)
    {
        $this->_rel = $value;
        return $this;
    }

    public function getValueString()
    {
        return $this->_valueString;
    }

    public function setValueString($value)
    {
        $this->_valueString = $value;
        return $this;
    }

    public function getEntryLink()
    {
        return $this->_entryLink;
    }

    public function setEntryLink($value)
    {
        $this->_entryLink = $value;
        return $this;
    }

}
