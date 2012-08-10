<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\App;

/**
 * Atom feed class
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage App
 */
class Feed extends AbstractFeedSourceParent
        implements \Iterator, \ArrayAccess, \Countable
{

    /**
     * The root xml element of this data element
     *
     * @var string
     */
    protected $_rootElement = 'feed';

    /**
     * Cache of feed entries.
     *
     * @var array
     */
    protected $_entry = array();

    /**
     * Current location in $_entry array
     *
     * @var int
     */
    protected $_entryIndex = 0;

    /**
     * Make accessing some individual elements of the feed easier.
     *
     * Special accessors 'entry' and 'entries' are provided so that if
     * you wish to iterate over an Atom feed's entries, you can do so
     * using foreach ($feed->entries as $entry) or foreach
     * ($feed->entry as $entry).
     *
     * @param  string $var The property to get.
     * @return mixed
     */
    public function __get($var)
    {
        switch ($var) {
            case 'entries':
                return $this;
            default:
                return parent::__get($var);
        }
    }

    /**
     * Retrieves the DOM model representing this object and all children
     *
     * @param \DOMDocument $doc
     * @return \DOMElement
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        foreach ($this->_entry as $entry) {
            $element->appendChild($entry->getDOM($element->ownerDocument));
        }
        return $element;
    }

    /**
     * Creates individual Entry objects of the appropriate type and
     * stores them in the $_entry array based upon DOM data.
     *
     * @param \DOMNode $child The DOMNode to process
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('atom') . ':' . 'entry':
            $newEntry = new $this->entryClassName($child);
            $newEntry->setService($this->getService());
            $newEntry->setMajorProtocolVersion($this->getMajorProtocolVersion());
            $newEntry->setMinorProtocolVersion($this->getMinorProtocolVersion());
            $this->_entry[] = $newEntry;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Get the number of entries in this feed object.
     *
     * @return integer Entry count.
     */
    public function count()
    {
        return count($this->_entry);
    }

    /**
     * Required by the Iterator interface.
     *
     * @return void
     */
    public function rewind()
    {
        $this->_entryIndex = 0;
    }

    /**
     * Required by the Iterator interface.
     *
     * @return mixed The current row, or null if no rows.
     */
    public function current()
    {
        return $this->_entry[$this->_entryIndex];
    }

    /**
     * Required by the Iterator interface.
     *
     * @return mixed The current row number (starts at 0), or NULL if no rows
     */
    public function key()
    {
        return $this->_entryIndex;
    }

    /**
     * Required by the Iterator interface.
     *
     * @return mixed The next row, or null if no more rows.
     */
    public function next()
    {
        ++$this->_entryIndex;
    }

    /**
     * Required by the Iterator interface.
     *
     * @return boolean Whether the iteration is valid
     */
    public function valid()
    {
        return 0 <= $this->_entryIndex && $this->_entryIndex < $this->count();
    }

    /**
     * Gets the array of atom:entry elements contained within this
     * atom:feed representation
     *
     * @return array|\ZendGData\App\Entry
     */
    public function getEntry()
    {
        return $this->_entry;
    }

    /**
     * Sets the array of atom:entry elements contained within this
     * atom:feed representation
     *
     * @param array $value The array of \ZendGData\App\Entry elements
     * @return \ZendGData\App\Feed Provides a fluent interface
     */
    public function setEntry($value)
    {
        $this->_entry = $value;
        return $this;
    }

    /**
     * Adds an entry representation to the array of entries
     * contained within this feed
     *
     * @param \ZendGData\App\Entry An individual entry to add.
     * @return \ZendGData\App\Feed Provides a fluent interface
     */
    public function addEntry($value)
    {
        $this->_entry[] = $value;
        return $this;
    }

    /**
     * Required by the ArrayAccess interface
     *
     * @param int $key The index to set
     * @param \ZendGData\App\Entry $value The value to set
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->_entry[$key] = $value;
    }

    /**
     * Required by the ArrayAccess interface
     *
     * @param int $key The index to get
     * @param \ZendGData\App\Entry $value The value to set
     */
    public function offsetGet($key)
    {
        if (array_key_exists($key, $this->_entry)) {
            return $this->_entry[$key];
        }
    }

    /**
     * Required by the ArrayAccess interface
     *
     * @param int $key The index to set
     * @param \ZendGData\App\Entry $value The value to set
     */
    public function offsetUnset($key)
    {
        if (array_key_exists($key, $this->_entry)) {
            unset($this->_entry[$key]);
        }
    }

    /**
     * Required by the ArrayAccess interface
     *
     * @param int $key The index to check for existence
     * @return boolean
     */
    public function offsetExists($key)
    {
        return (array_key_exists($key, $this->_entry));
    }

   /**
     * Retrieve the next set of results from this feed.
     *
     * @throws \ZendGData\App\Exception
     * @return mixed|null Returns the next set of results as a feed of the same
     *          class as this feed, or null if no results exist.
     */
    public function getNextFeed()
    {
        $nextLink = $this->getNextLink();
        if (!$nextLink) {
            throw new Exception('No link to next set ' .
            'of results found.');
        }
        $nextLinkHref = $nextLink->getHref();
        $service = $this->getService();

        return $service->getFeed($nextLinkHref, get_called_class());
    }

   /**
     * Retrieve the previous set of results from this feed.
     *
     * @throws \ZendGData\App\Exception
     * @return mixed|null Returns the previous set of results as a feed of
     *          the same class as this feed, or null if no results exist.
     */
    public function getPreviousFeed()
    {
        $previousLink = $this->getPreviousLink();
        if (!$previousLink) {
            throw new Exception('No link to previous set ' .
            'of results found.');
        }
        $previousLinkHref = $previousLink->getHref();
        $service = $this->getService();

        return $service->getFeed($previousLinkHref, get_called_class());
    }

    /**
     * Set the major protocol version that should be used. Values < 1 will
     * cause a \ZendGData\App\InvalidArgumentException to be thrown.
     *
     * This value will be propagated to all child entries.
     *
     * @see _majorProtocolVersion
     * @param (int|NULL) $value The major protocol version to use.
     * @throws \ZendGData\App\InvalidArgumentException
     */
    public function setMajorProtocolVersion($value)
    {
        parent::setMajorProtocolVersion($value);
        foreach ($this->entries as $entry) {
            $entry->setMajorProtocolVersion($value);
        }
    }

    /**
     * Set the minor protocol version that should be used. If set to NULL, no
     * minor protocol version will be sent to the server. Values < 0 will
     * cause a \ZendGData\App\InvalidArgumentException to be thrown.
     *
     * This value will be propogated to all child entries.
     *
     * @see _minorProtocolVersion
     * @param (int|NULL) $value The minor protocol version to use.
     * @throws \ZendGData\App\InvalidArgumentException
     */
    public function setMinorProtocolVersion($value)
    {
        parent::setMinorProtocolVersion($value);
        foreach ($this->entries as $entry) {
            $entry->setMinorProtocolVersion($value);
        }
    }

}
