<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\GApps;

use ZendGData\GApps;

/**
 * Data model class for a Google Apps Email List Entry.
 *
 * Each email list entry describes a single email list within a Google Apps
 * hosted domain. Email lists may contain multiple recipients, as
 * described by instances of ZendGData\GApps\EmailListRecipient. Multiple
 * entries are contained within instances of ZendGData\GApps\EmailListFeed.
 *
 * To transfer email list entries to and from the Google Apps servers,
 * including creating new entries, refer to the Google Apps service class,
 * ZendGData\GApps.
 *
 * This class represents <atom:entry> in the Google Data protocol.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GApps
 */
class EmailListEntry extends \ZendGData\Entry
{

    protected $_entryClassName = 'ZendGData\GApps\EmailListEntry';

    /**
     * <apps:emailList> child element containing general information about
     * this email list.
     *
     * @var \ZendGData\GApps\Extension\EmailList
     */
    protected $_emailList = null;

    /**
     * <gd:feedLink> element containing information about other feeds
     * relevant to this entry.
     *
     * @var \ZendGData\Extension\FeedLink
     */
    protected $_feedLink = array();

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(GApps::$namespaces);
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
        if ($this->_emailList !== null) {
            $element->appendChild($this->_emailList->getDOM($element->ownerDocument));
        }
        foreach ($this->_feedLink as $feedLink) {
            $element->appendChild($feedLink->getDOM($element->ownerDocument));
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
            case $this->lookupNamespace('apps') . ':' . 'emailList';
                $emailList = new Extension\EmailList();
                $emailList->transferFromDOM($child);
                $this->_emailList = $emailList;
                break;
            case $this->lookupNamespace('gd') . ':' . 'feedLink';
                $feedLink = new \ZendGData\Extension\FeedLink();
                $feedLink->transferFromDOM($child);
                $this->_feedLink[] = $feedLink;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    /**
     * Retrieve the email list property for this entry.
     *
     * @see setEmailList
     * @return \ZendGData\GApps\Extension\EmailList The requested object
     *              or null if not set.
     */
    public function getEmailList()
    {
        return $this->_emailList;
    }

    /**
     * Set the email list property for this entry. This property contains
     * information such as the name of this email list.
     *
     * This corresponds to the <apps:emailList> property in the Google Data
     * protocol.
     *
     * @param \ZendGData\GApps\Extension\EmailList $value The desired value
     *              this element, or null to unset.
     * @return EmailListEntry Provides a fluent interface
     */
    public function setEmailList($value)
    {
        $this->_emailList = $value;
        return $this;
    }

    /**
     * Get the feed link property for this entry.
     *
     * @see setFeedLink
     * @param string $rel (optional) The rel value of the link to be found.
     *          If null, the array of links is returned.
     * @return mixed If $rel is specified, a \ZendGData\Extension\FeedLink
     *          object corresponding to the requested rel value is returned
     *          if found, or null if the requested value is not found. If
     *          $rel is null or not specified, an array of all available
     *          feed links for this entry is returned, or null if no feed
     *          links are set.
     */
    public function getFeedLink($rel = null)
    {
        if ($rel == null) {
            return $this->_feedLink;
        } else {
            foreach ($this->_feedLink as $feedLink) {
                if ($feedLink->rel == $rel) {
                    return $feedLink;
                }
            }
            return null;
        }
    }

    /**
     * Set the feed link property for this entry. Feed links provide
     * information about other feeds associated with this entry.
     *
     * This corresponds to the <gd:feedLink> property in the Google Data
     * protocol.
     *
     * @param array $value A collection of ZendGData\GApps\Extension\FeedLink
     *          instances representing all feed links for this entry, or
     *          null to unset.
     * @return EmailListEntry Provides a fluent interface
     */
    public function setFeedLink($value)
    {
        $this->_feedLink = $value;
        return $this;
    }

}
