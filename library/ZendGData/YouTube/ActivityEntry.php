<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\YouTube;

use ZendGData\YouTube;

/**
 * A concrete class for working with YouTube user activity entries.
 *
 * @link http://code.google.com/apis/youtube/
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class ActivityEntry extends \ZendGData\Entry
{
    const ACTIVITY_CATEGORY_SCHEME =
        'http://gdata.youtube.com/schemas/2007/userevents.cat';

    /**
     * The classname for individual user activity entry elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\YouTube\ActivityEntry';

    /**
     * The ID of the video that was part of the activity
     *
     * @var Extension\VideoId
     */
    protected $_videoId = null;

    /**
     * The username for the user that was part of the activity
     *
     * @var Extension\Username
     */
    protected $_username = null;

    /**
     * The rating element that was part of the activity
     *
     * @var \ZendGData\Extension\Rating
     */
    protected $_rating = null;

    /**
     * Constructs a new ZendGData\YouTube\ActivityEntry object.
     * @param DOMElement $element (optional) The DOMElement on which to
     * base this object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(YouTube::$namespaces);
        parent::__construct($element);
    }

    /**
     * Retrieves a DOMElement which corresponds to this element and all
     * child properties.  This is used to build an entry back into a DOM
     * and eventually XML text for application storage/persistence.
     *
     * @param DOMDocument $doc The DOMDocument used to construct DOMElements
     * @return DOMElement The DOMElement representing this element and all
     *          child properties.
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_videoId !== null) {
          $element->appendChild($this->_videoId->getDOM(
              $element->ownerDocument));
        }
        if ($this->_username !== null) {
          $element->appendChild($this->_username->getDOM(
              $element->ownerDocument));
        }
        if ($this->_rating !== null) {
          $element->appendChild($this->_rating->getDOM(
              $element->ownerDocument));
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
            case $this->lookupNamespace('yt') . ':' . 'videoid':
                $videoId = new Extension\VideoId();
                $videoId->transferFromDOM($child);
                $this->_videoId = $videoId;
                break;
            case $this->lookupNamespace('yt') . ':' . 'username':
                $username = new Extension\Username();
                $username->transferFromDOM($child);
                $this->_username = $username;
                break;
            case $this->lookupNamespace('gd') . ':' . 'rating':
                $rating = new \ZendGData\Extension\Rating();
                $rating->transferFromDOM($child);
                $this->_rating = $rating;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    /**
     * Returns the video ID for this activity entry.
     *
     * @return null|\ZendGData\YouTube\Extension\VideoId
     */
    public function getVideoId()
    {
        return $this->_videoId;
    }

    /**
     * Returns the username for this activity entry.
     *
     * @return null|\ZendGData\YouTube\Extension\Username
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * Returns the rating for this activity entry.
     *
     * @return null|Extension\Rating
     */
    public function getRating()
    {
        return $this->_rating;
    }

    /**
     * Return the value of the rating for this video entry.
     *
     * Convenience method to save needless typing.
     *
     * @return integer|null The value of the rating that was created, if found.
     */
    public function getRatingValue()
    {
        $rating = $this->_rating;
        if ($rating) {
            return $rating->getValue();
        }
        return null;
    }

    /**
     * Return the activity type that was performed.
     *
     * Convenience method that inspects category where scheme is
     * http://gdata.youtube.com/schemas/2007/userevents.cat.
     *
     * @return string|null The activity category if found.
     */
    public function getActivityType()
    {
        $categories = $this->getCategory();
        foreach($categories as $category) {
            if ($category->getScheme() == self::ACTIVITY_CATEGORY_SCHEME) {
                return $category->getTerm();
            }
        }
        return null;
    }

    /**
     * Convenience method to quickly get access to the author of the activity
     *
     * @return string The author of the activity
     */
    public function getAuthorName()
    {
        $authors = $this->getAuthor();
        return $authors[0]->getName()->getText();
    }
}
