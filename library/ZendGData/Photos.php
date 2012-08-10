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
 * Service class for interacting with the Google Photos Data API.
 *
 * Like other service classes in this module, this class provides access via
 * an HTTP client to Google servers for working with entries and feeds.
 *
 * @link http://code.google.com/apis/picasaweb/gdata.html
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Photos
 */
class Photos extends GData
{

    const PICASA_BASE_URI = 'https://picasaweb.google.com/data';
    const PICASA_BASE_FEED_URI = 'https://picasaweb.google.com/data/feed';
    const AUTH_SERVICE_NAME = 'lh2';

    /**
     * Default projection when interacting with the Picasa server.
     */
    const DEFAULT_PROJECTION = 'api';

    /**
     * The default visibility to filter events by.
     */
    const DEFAULT_VISIBILITY = 'all';

    /**
     * The default user to retrieve feeds for.
     */
    const DEFAULT_USER = 'default';

    /**
     * Path to the user feed on the Picasa server.
     */
    const USER_PATH = 'user';

    /**
     * Path to album feeds on the Picasa server.
     */
    const ALBUM_PATH = 'albumid';

    /**
     * Path to photo feeds on the Picasa server.
     */
    const PHOTO_PATH = 'photoid';

    /**
     * The path to the community search feed on the Picasa server.
     */
    const COMMUNITY_SEARCH_PATH = 'all';

    /**
     * The path to use for finding links to feeds within entries
     */
    const FEED_LINK_PATH = 'http://schemas.google.com/g/2005#feed';

    /**
     * The path to use for the determining type of an entry
     */
    const KIND_PATH = 'http://schemas.google.com/g/2005#kind';

    /**
     * Namespaces used for ZendGData\Photos
     *
     * @var array
     */
    public static $namespaces = array(
        array('gphoto', 'http://schemas.google.com/photos/2007', 1, 0),
        array('photo', 'http://www.pheed.com/pheed/', 1, 0),
        array('exif', 'http://schemas.google.com/photos/exif/2007', 1, 0),
        array('georss', 'http://www.georss.org/georss', 1, 0),
        array('gml', 'http://www.opengis.net/gml', 1, 0),
        array('media', 'http://search.yahoo.com/mrss/', 1, 0)
    );

    /**
     * Create ZendGData\Photos object
     *
     * @param \Zend\Http\Client $client (optional) The HTTP client to use when
     *          when communicating with the servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('ZendGData\Photos');
        $this->registerPackage('ZendGData\Photos\Extension');
        parent::__construct($client, $applicationId);
        $this->_httpClient->setParameterPost(array('service' => self::AUTH_SERVICE_NAME));
    }

    /**
     * Retrieve a UserFeed containing AlbumEntries, PhotoEntries and
     * TagEntries associated with a given user.
     *
     * @param string $userName The userName of interest
     * @param mixed $location (optional) The location for the feed, as a URL
     *          or Query. If not provided, a default URL will be used instead.
     * @return \ZendGData\Photos\UserFeed
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function getUserFeed($userName = null, $location = null)
    {
        if ($location instanceof Photos\UserQuery) {
            $location->setType('feed');
            if ($userName !== null) {
                $location->setUser($userName);
            }
            $uri = $location->getQueryUrl();
        } elseif ($location instanceof Query) {
            if ($userName !== null) {
                $location->setUser($userName);
            }
            $uri = $location->getQueryUrl();
        } elseif ($location !== null) {
            $uri = $location;
        } elseif ($userName !== null) {
            $uri = self::PICASA_BASE_FEED_URI . '/' .
                self::DEFAULT_PROJECTION . '/' . self::USER_PATH . '/' .
                $userName;
        } else {
            $uri = self::PICASA_BASE_FEED_URI . '/' .
                self::DEFAULT_PROJECTION . '/' . self::USER_PATH . '/' .
                self::DEFAULT_USER;
        }

        return parent::getFeed($uri, 'ZendGData\Photos\UserFeed');
    }

    /**
     * Retreive AlbumFeed object containing multiple PhotoEntry or TagEntry
     * objects.
     *
     * @param mixed $location (optional) The location for the feed, as a URL or Query.
     * @return \ZendGData\Photos\AlbumFeed
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function getAlbumFeed($location = null)
    {
        if ($location === null) {
            throw new App\InvalidArgumentException(
                    'Location must not be null');
        } elseif ($location instanceof Photos\UserQuery) {
            $location->setType('feed');
            $uri = $location->getQueryUrl();
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'ZendGData\Photos\AlbumFeed');
    }

    /**
     * Retreive PhotoFeed object containing comments and tags associated
     * with a given photo.
     *
     * @param mixed $location (optional) The location for the feed, as a URL
     *          or Query. If not specified, the community search feed will
     *          be returned instead.
     * @return \ZendGData\Photos\PhotoFeed
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function getPhotoFeed($location = null)
    {
        if ($location === null) {
            $uri = self::PICASA_BASE_FEED_URI . '/' .
                self::DEFAULT_PROJECTION . '/' .
                self::COMMUNITY_SEARCH_PATH;
        } elseif ($location instanceof Photos\UserQuery) {
            $location->setType('feed');
            $uri = $location->getQueryUrl();
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'ZendGData\Photos\PhotoFeed');
    }

    /**
     * Retreive a single UserEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return \ZendGData\Photos\UserEntry
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function getUserEntry($location)
    {
        if ($location === null) {
            throw new App\InvalidArgumentException(
                    'Location must not be null');
        } elseif ($location instanceof Photos\UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, '\ZendGData\Photos\UserEntry');
    }

    /**
     * Retreive a single AlbumEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return \ZendGData\Photos\AlbumEntry
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function getAlbumEntry($location)
    {
        if ($location === null) {
            throw new App\InvalidArgumentException(
                    'Location must not be null');
        } elseif ($location instanceof Photos\UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'ZendGData\Photos\AlbumEntry');
    }

    /**
     * Retreive a single PhotoEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return \ZendGData\Photos\PhotoEntry
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function getPhotoEntry($location)
    {
        if ($location === null) {
            throw new App\InvalidArgumentException(
                    'Location must not be null');
        } elseif ($location instanceof Photos\UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'ZendGData\Photos\PhotoEntry');
    }

    /**
     * Retreive a single TagEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return \ZendGData\Photos\TagEntry
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function getTagEntry($location)
    {
        if ($location === null) {
            throw new App\InvalidArgumentException(
                    'Location must not be null');
        } elseif ($location instanceof Photos\UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'ZendGData\Photos\TagEntry');
    }

    /**
     * Retreive a single CommentEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return \ZendGData\Photos\CommentEntry
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function getCommentEntry($location)
    {
        if ($location === null) {
            throw new App\InvalidArgumentException(
                    'Location must not be null');
        } elseif ($location instanceof Photos\UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } elseif ($location instanceof Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'ZendGData\Photos\CommentEntry');
    }

    /**
     * Create a new album from a AlbumEntry.
     *
     * @param \ZendGData\Photos\AlbumEntry $album The album entry to
     *          insert.
     * @param string $url (optional) The URI that the album should be
     *          uploaded to. If null, the default album creation URI for
     *          this domain will be used.
     * @return \ZendGData\Photos\AlbumEntry The inserted album entry as
     *          returned by the server.
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function insertAlbumEntry($album, $uri = null)
    {
        if ($uri === null) {
            $uri = self::PICASA_BASE_FEED_URI . '/' .
                self::DEFAULT_PROJECTION . '/' . self::USER_PATH . '/' .
                self::DEFAULT_USER;
        }
        $newEntry = $this->insertEntry($album, $uri, 'ZendGData\Photos\AlbumEntry');
        return $newEntry;
    }

    /**
     * Create a new photo from a PhotoEntry.
     *
     * @param \ZendGData\Photos\PhotoEntry $photo The photo to insert.
     * @param string $url The URI that the photo should be uploaded
     *          to. Alternatively, an AlbumEntry can be provided and the
     *          photo will be added to that album.
     * @return \ZendGData\Photos\PhotoEntry The inserted photo entry
     *          as returned by the server.
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function insertPhotoEntry($photo, $uri = null)
    {
        if ($uri instanceof AlbumEntry) {
            $uri = $uri->getLink(self::FEED_LINK_PATH)->href;
        }
        if ($uri === null) {
            throw new App\InvalidArgumentException(
                    'URI must not be null');
        }
        $newEntry = $this->insertEntry($photo, $uri, 'ZendGData\Photos\PhotoEntry');
        return $newEntry;
    }

    /**
     * Create a new tag from a TagEntry.
     *
     * @param \ZendGData\Photos\TagEntry $tag The tag entry to insert.
     * @param string $url The URI where the tag should be
     *          uploaded to. Alternatively, a PhotoEntry can be provided and
     *          the tag will be added to that photo.
     * @return \ZendGData\Photos\TagEntry The inserted tag entry as returned
     *          by the server.
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function insertTagEntry($tag, $uri = null)
    {
        if ($uri instanceof PhotoEntry) {
            $uri = $uri->getLink(self::FEED_LINK_PATH)->href;
        }
        if ($uri === null) {
            throw new App\InvalidArgumentException(
                    'URI must not be null');
        }
        $newEntry = $this->insertEntry($tag, $uri, 'ZendGData\Photos\TagEntry');
        return $newEntry;
    }

    /**
     * Create a new comment from a CommentEntry.
     *
     * @param \ZendGData\Photos\CommentEntry $comment The comment entry to
     *          insert.
     * @param string $url The URI where the comment should be uploaded to.
     *          Alternatively, a PhotoEntry can be provided and
     *          the comment will be added to that photo.
     * @return \ZendGData\Photos\CommentEntry The inserted comment entry
     *          as returned by the server.
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function insertCommentEntry($comment, $uri = null)
    {
        if ($uri instanceof PhotoEntry) {
            $uri = $uri->getLink(self::FEED_LINK_PATH)->href;
        }
        if ($uri === null) {
            throw new App\InvalidArgumentException(
                    'URI must not be null');
        }
        $newEntry = $this->insertEntry($comment, $uri, 'ZendGData\Photos\CommentEntry');
        return $newEntry;
    }

    /**
     * Delete an AlbumEntry.
     *
     * @param \ZendGData\Photos\AlbumEntry $album The album entry to
     *          delete.
     * @param boolean $catch Whether to catch an exception when
     *            modified and re-delete or throw
     * @return void.
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function deleteAlbumEntry($album, $catch)
    {
        if ($catch) {
            try {
                $this->delete($album);
            } catch (App\HttpException $e) {
                if ($e->getResponse()->getStatusCode() === 409) {
                    $entry = new AlbumEntry($e->getResponse()->getBody());
                    $this->delete($entry->getLink('edit')->href);
                } else {
                    throw $e;
                }
            }
        } else {
            $this->delete($album);
        }
    }

    /**
     * Delete a PhotoEntry.
     *
     * @param \ZendGData\Photos\PhotoEntry $photo The photo entry to
     *          delete.
     * @param boolean $catch Whether to catch an exception when
     *            modified and re-delete or throw
     * @return void.
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function deletePhotoEntry($photo, $catch)
    {
        if ($catch) {
            try {
                $this->delete($photo);
            } catch (App\HttpException $e) {
                if ($e->getResponse()->getStatusCode() === 409) {
                    $entry = new PhotoEntry($e->getResponse()->getBody());
                    $this->delete($entry->getLink('edit')->href);
                } else {
                    throw $e;
                }
            }
        } else {
            $this->delete($photo);
        }
    }

    /**
     * Delete a CommentEntry.
     *
     * @param \ZendGData\Photos\CommentEntry $comment The comment entry to
     *          delete.
     * @param boolean $catch Whether to catch an exception when
     *            modified and re-delete or throw
     * @return void.
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function deleteCommentEntry($comment, $catch)
    {
        if ($catch) {
            try {
                $this->delete($comment);
            } catch (App\HttpException $e) {
                if ($e->getResponse()->getStatusCode() === 409) {
                    $entry = new CommentEntry($e->getResponse()->getBody());
                    $this->delete($entry->getLink('edit')->href);
                } else {
                    throw $e;
                }
            }
        } else {
            $this->delete($comment);
        }
    }

    /**
     * Delete a TagEntry.
     *
     * @param \ZendGData\Photos\TagEntry $tag The tag entry to
     *          delete.
     * @param boolean $catch Whether to catch an exception when
     *            modified and re-delete or throw
     * @return void.
     * @throws \ZendGData\App\Exception
     * @throws \ZendGData\App\HttpException
     */
    public function deleteTagEntry($tag, $catch)
    {
        if ($catch) {
            try {
                $this->delete($tag);
            } catch (App\HttpException $e) {
                if ($e->getResponse()->getStatusCode() === 409) {
                    $entry = new TagEntry($e->getResponse()->getBody());
                    $this->delete($entry->getLink('edit')->href);
                } else {
                    throw $e;
                }
            }
        } else {
            $this->delete($tag);
        }
    }

}
