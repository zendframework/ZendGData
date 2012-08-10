<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Spreadsheets;

use ZendGData\App;
use ZendGData\Spreadsheets;

/**
 * Concrete class for working with List entries.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Spreadsheets
 */
class ListEntry extends \ZendGData\Entry
{

    protected $_entryClassName = 'ZendGData\Spreadsheets\ListEntry';

    /**
     * List of custom row elements (ZendGData\Spreadsheets\Extension\Custom),
     * indexed by order added to this entry.
     * @var array
     */
    protected $_custom = array();

    /**
     * List of custom row elements (ZendGData\Spreadsheets\Extension\Custom),
     * indexed by element name.
     * @var array
     */
    protected $_customByName = array();

    /**
     * Constructs a new ZendGData\Spreadsheets\ListEntry object.
     * @param DOMElement $element An existing XML element on which to base this new object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Spreadsheets::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if (!empty($this->_custom)) {
            foreach ($this->_custom as $custom) {
                $element->appendChild($custom->getDOM($element->ownerDocument));
            }
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        switch ($child->namespaceURI) {
        case $this->lookupNamespace('gsx');
            $custom = new Extension\Custom($child->localName);
            $custom->transferFromDOM($child);
            $this->addCustom($custom);
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Gets the row elements contained by this list entry.
     * @return array The custom row elements in this list entry
     */
    public function getCustom()
    {
        return $this->_custom;
    }

    /**
     * Gets a single row element contained by this list entry using its name.
     * @param string $name The name of a custom element to return. If null
     *          or not defined, an array containing all custom elements
     *          indexed by name will be returned.
     * @return mixed If a name is specified, the
     *          ZendGData\Spreadsheets\Extension\Custom element requested,
     *          is returned or null if not found. Otherwise, an array of all
     *          ZendGData\Spreadsheets\Extension\Custom elements is returned
     *          indexed by name.
     */
    public function getCustomByName($name = null)
    {
        if ($name === null) {
            return $this->_customByName;
        } else {
            if (array_key_exists($name, $this->customByName)) {
                return $this->_customByName[$name];
            } else {
                return null;
            }
        }
    }

    /**
     * Sets the row elements contained by this list entry. If any
     * custom row elements were previously stored, they will be overwritten.
     * @param array $custom The custom row elements to be contained in this
     *          list entry.
     * @return \ZendGData\Spreadsheets\ListEntry Provides a fluent interface.
     */
    public function setCustom($custom)
    {
        $this->_custom = array();
        foreach ($custom as $c) {
            $this->addCustom($c);
        }
        return $this;
    }

    /**
     * Add an individual custom row element to this list entry.
     * @param \ZendGData\Spreadsheets\Extension\Custom $custom The custom
     *             element to be added.
     * @return \ZendGData\Spreadsheets\ListEntry Provides a fluent interface.
     */
    public function addCustom($custom)
    {
        $this->_custom[] = $custom;
        $this->_customByName[$custom->getColumnName()] = $custom;
        return $this;
    }

    /**
     * Remove an individual row element from this list entry by index. This
     * will cause the array to be re-indexed.
     * @param int $index The index of the custom element to be deleted.
     * @return \ZendGData\Spreadsheets\ListEntry Provides a fluent interface.
     * @throws \ZendGData\App\InvalidArgumentException
     */
    public function removeCustom($index)
    {
        if (array_key_exists($index, $this->_custom)) {
            $element = $this->_custom[$index];
            // Remove element
            unset($this->_custom[$index]);
            // Re-index the array
            $this->_custom = array_values($this->_custom);
            // Be sure to delete form both arrays!
            $key = array_search($element, $this->_customByName);
            unset($this->_customByName[$key]);
        } else {
            throw new App\InvalidArgumentException(
                'Element does not exist.');
        }
        return $this;
    }

    /**
     * Remove an individual row element from this list entry by name.
     * @param string $name The name of the custom element to be deleted.
     * @return \ZendGData\Spreadsheets\ListEntry Provides a fluent interface.
     * @throws \ZendGData\App\InvalidArgumentException
     */
    public function removeCustomByName($name)
    {
        if (array_key_exists($name, $this->_customByName)) {
            $element = $this->_customByName[$name];
            // Remove element
            unset($this->_customByName[$name]);
            // Be sure to delete from both arrays!
            $key = array_search($element, $this->_custom);
            unset($this->_custom[$key]);
        } else {
            throw new App\InvalidArgumentException(
                'Element does not exist.');
        }
        return $this;
    }

}
