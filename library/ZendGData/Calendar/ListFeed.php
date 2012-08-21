<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Calendar;

use ZendGData\Calendar;

/**
 * Represents the meta-feed list of calendars
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Calendar
 */
class ListFeed extends \ZendGData\Feed
{
    protected $_timezone = null;

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\Calendar\ListEntry';

    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'ZendGData\Calendar\ListFeed';

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Calendar::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_timezone != null) {
            $element->appendChild($this->_timezone->getDOM($element->ownerDocument));
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('gCal') . ':' . 'timezone';
            $timezone = new Extension\Timezone();
            $timezone->transferFromDOM($child);
            $this->_timezone = $timezone;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    public function getTimezone()
    {
        return $this->_timezone;
    }

    /**
     * @param \ZendGData\Calendar\Extension\Timezone $value
     * @return \ZendGData\Calendar\ListFeed Provides a fluent interface
     */
    public function setTimezone($value)
    {
        $this->_timezone = $value;
        return $this;
    }

}
