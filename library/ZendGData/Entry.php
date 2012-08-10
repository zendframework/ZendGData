<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData;

use Zend\Http\Header\Etag;

/**
 * Represents the ZendGData flavor of an Atom entry
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GData
 */
class Entry extends App\MediaEntry
{

    protected $_entryClassName = '\ZendGData\Entry';

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(GData::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        // ETags are special. We only support them in protocol >= 2.X.
        // This will be duplicated by the HTTP ETag header.
        if ($majorVersion >= 2) {
            if ($this->_etag instanceof Etag) {
                $element->setAttributeNS($this->lookupNamespace('gd'),
                                         'gd:etag',
                                         $this->_etag->getFieldValue());
            }
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('atom') . ':' . 'content':
            $content = new App\Extension\Content();
            $content->transferFromDOM($child);
            $this->_content = $content;
            break;
        case $this->lookupNamespace('atom') . ':' . 'published':
            $published = new App\Extension\Published();
            $published->transferFromDOM($child);
            $this->_published = $published;
            break;
        case $this->lookupNamespace('atom') . ':' . 'source':
            $source = new App\Extension\Source();
            $source->transferFromDOM($child);
            $this->_source = $source;
            break;
        case $this->lookupNamespace('atom') . ':' . 'summary':
            $summary = new App\Extension\Summary();
            $summary->transferFromDOM($child);
            $this->_summary = $summary;
            break;
        case $this->lookupNamespace('app') . ':' . 'control':
            $control = new App\Extension\Control();
            $control->transferFromDOM($child);
            $this->_control = $control;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
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
        case 'etag':
            // ETags are special, since they can be conveyed by either the
            // HTTP ETag header or as an XML attribute.
            $etag = $attribute->nodeValue;
            if ($this->_etag === null) {
                $this->_etag = $etag;
            } elseif ($this->_etag->getFieldValue() != $etag) {
                throw new App\IOException("ETag mismatch");
            }
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
            break;
        }
    }

}
