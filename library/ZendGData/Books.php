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
 * Service class for interacting with the Books service
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Books
 */
class Books extends GData
{
    const VOLUME_FEED_URI = 'https://books.google.com/books/feeds/volumes';
    const MY_LIBRARY_FEED_URI = 'https://books.google.com/books/feeds/users/me/collections/library/volumes';
    const MY_ANNOTATION_FEED_URI = 'https://books.google.com/books/feeds/users/me/volumes';
    const AUTH_SERVICE_NAME = 'print';

    /**
     * Namespaces used for ZendGData\Books
     *
     * @var array
     */
    public static $namespaces = array(
        array('gbs', 'http://schemas.google.com/books/2008', 1, 0),
        array('dc', 'http://purl.org/dc/terms', 1, 0)
    );

    /**
     * Create ZendGData\Books object
     *
     * @param \Zend\Http\Client $client (optional) The HTTP client to use when
     *          when communicating with the Google servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('ZendGData\Books');
        $this->registerPackage('ZendGData\Books\Extension');
        parent::__construct($client, $applicationId);
        $this->_httpClient->setParameterPost(array('service' => self::AUTH_SERVICE_NAME));
     }

    /**
     * Retrieves a feed of volumes.
     *
     * @param \ZendGData\Query|string|null $location (optional) The URL to
     *        query or a ZendGData\Query object from which a URL can be
     *        determined.
     * @return \ZendGData\Books\VolumeFeed The feed of volumes found at the
     *         specified URL.
     */
    public function getVolumeFeed($location = null)
    {
        if ($location == null) {
            $uri = self::VOLUME_FEED_URI;
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'ZendGData\Books\VolumeFeed');
    }

    /**
     * Retrieves a specific volume entry.
     *
     * @param string|null $volumeId The volumeId of interest.
     * @param \ZendGData\Query|string|null $location (optional) The URL to
     *        query or a ZendGData\Query object from which a URL can be
     *        determined.
     * @return \ZendGData\Books\VolumeEntry The feed of volumes found at the
     *         specified URL.
     */
    public function getVolumeEntry($volumeId = null, $location = null)
    {
        if ($volumeId !== null) {
            $uri = self::VOLUME_FEED_URI . "/" . $volumeId;
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'ZendGData\Books\VolumeEntry');
    }

    /**
     * Retrieves a feed of volumes, by default the User library feed.
     *
     * @param \ZendGData\Query|string|null $location (optional) The URL to
     *        query.
     * @return \ZendGData\Books\VolumeFeed The feed of volumes found at the
     *         specified URL.
     */
    public function getUserLibraryFeed($location = null)
    {
        if ($location == null) {
            $uri = self::MY_LIBRARY_FEED_URI;
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'ZendGData\Books\VolumeFeed');
    }

    /**
     * Retrieves a feed of volumes, by default the User annotation feed
     *
     * @param \ZendGData\Query|string|null $location (optional) The URL to
     *        query.
     * @return \ZendGData\Books\VolumeFeed The feed of volumes found at the
     *         specified URL.
     */
    public function getUserAnnotationFeed($location = null)
    {
        if ($location == null) {
            $uri = self::MY_ANNOTATION_FEED_URI;
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'ZendGData\Books\VolumeFeed');
    }

    /**
     * Insert a Volume / Annotation
     *
     * @param \ZendGData\Books\VolumeEntry $entry
     * @param \ZendGData\Query|string|null $location (optional) The URL to
     *        query
     * @return \ZendGData\Books\VolumeEntry The inserted volume entry.
     */
    public function insertVolume($entry, $location = null)
    {
        if ($location == null) {
            $uri = self::MY_LIBRARY_FEED_URI;
        } else {
            $uri = $location;
        }
        return parent::insertEntry(
            $entry, $uri, 'ZendGData\Books\VolumeEntry');
    }

    /**
     * Delete a Volume
     *
     * @param \ZendGData\Books\VolumeEntry $entry
     * @return void
     */
    public function deleteVolume($entry)
    {
        $entry->delete();
    }

}
