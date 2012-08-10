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
 * Specialized Control class for use with YouTube. Enables use of yt extension elements.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class Control extends \ZendGData\App\Extension\Control
{

    protected $_state = null;

    /**
     * Constructs a new ZendGData\YouTube\Extension\Control object.
     * @see ZendGData\App\Extension\Control#__construct
     * @param \ZendGData\App\Extension\Draft $draft
     * @param \ZendGData\YouTube\Extension\State $state
     */
    public function __construct($draft = null, $state = null)
    {
        $this->registerAllNamespaces(\ZendGData\YouTube::$namespaces);
        parent::__construct($draft);
        $this->_state = $state;
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
        if ($this->_state != null) {
            $element->appendChild($this->_state->getDOM($element->ownerDocument));
        }
        return $element;
    }

    /**
     * Creates individual Entry objects of the appropriate type and
     * stores them as members of this entry based upon DOM data.
     *
     * @param DOMNode $child The DOMNode to process
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('yt') . ':' . 'state':
            $state = new State();
            $state->transferFromDOM($child);
            $this->_state = $state;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Get the value for this element's state attribute.
     *
     * @return \ZendGData\YouTube\Extension\State The state element.
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Set the value for this element's state attribute.
     *
     * @param \ZendGData\YouTube\Extension\State $value The desired value for this attribute.
     * @return \ZendGData\YouTube\Extension\Control The element being modified.
     */
    public function setState($value)
    {
        $this->_state = $value;
        return $this;
    }

    /**
    * Get the value of this element's state attribute.
    *
    * @return string The state's text value
    */
    public function getStateValue()
    {
      return $this->getState()->getText();
    }

}
