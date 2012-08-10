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

/**
 * Service class for interacting with the Google Calendar data API
 * @link http://code.google.com/apis/gdata/calendar.html
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Calendar
 */
class Calendar extends GData
{

    const CALENDAR_FEED_URI = 'https://www.google.com/calendar/feeds';
    const CALENDAR_EVENT_FEED_URI = 'https://www.google.com/calendar/feeds/default/private/full';
    const AUTH_SERVICE_NAME = 'cl';

    protected $_defaultPostUri = self::CALENDAR_EVENT_FEED_URI;

    /**
     * Namespaces used for ZendGData\Calendar
     *
     * @var array
     */
    public static $namespaces = array(
        array('gCal', 'http://schemas.google.com/gCal/2005', 1, 0)
    );

    /**
     * Create ZendGData\Calendar object
     *
     * @param \Zend\Http\Client $client (optional) The HTTP client to use when
     *          when communicating with the Google servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('ZendGData\Calendar');
        $this->registerPackage('ZendGData\Calendar\Extension');
        parent::__construct($client, $applicationId);
        $this->_httpClient->setParameterPost(array('service' => self::AUTH_SERVICE_NAME));
    }

    /**
     * Retreive feed object
     *
     * @param mixed $location The location for the feed, as a URL or Query
     * @return \ZendGData\Calendar\EventFeed
     */
    public function getCalendarEventFeed($location = null)
    {
        if ($location == null) {
            $uri = self::CALENDAR_EVENT_FEED_URI;
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'ZendGData\Calendar\EventFeed');
    }

    /**
     * Retreive entry object
     *
     * @return \ZendGData\Calendar\EventEntry
     */
    public function getCalendarEventEntry($location = null)
    {
        if ($location == null) {
            throw new App\InvalidArgumentException(
                    'Location must not be null');
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'ZendGData\Calendar\EventEntry');
    }


    /**
     * Retrieve feed object
     *
     * @return \ZendGData\Calendar\ListFeed
     */
    public function getCalendarListFeed()
    {
        $uri = self::CALENDAR_FEED_URI . '/default';
        return parent::getFeed($uri,'ZendGData\Calendar\ListFeed');
    }

    /**
     * Retreive entryobject
     *
     * @return \ZendGData\Calendar\ListEntry
     */
    public function getCalendarListEntry($location = null)
    {
        if ($location == null) {
            throw new App\InvalidArgumentException(
                    'Location must not be null');
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri,'ZendGData\Calendar\ListEntry');
    }

    public function insertEvent($event, $uri=null)
    {
        if ($uri == null) {
            $uri = $this->_defaultPostUri;
        }
        $newEvent = $this->insertEntry($event, $uri, 'ZendGData\Calendar\EventEntry');
        return $newEvent;
    }

}
