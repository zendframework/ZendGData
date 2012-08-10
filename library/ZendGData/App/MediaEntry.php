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
 * Concrete class for working with Atom entries containing multi-part data.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage App
 */
class MediaEntry extends Entry
{
    /**
     * The attached MediaSource/file
     *
     * @var \ZendGData\App\MediaSource
     */
    protected $_mediaSource = null;

    /**
     * Constructs a new MediaEntry, representing XML data and optional
     * file to upload
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null, $mediaSource = null)
    {
        parent::__construct($element);
        $this->_mediaSource = $mediaSource;
    }

    /**
     * Return the MIME multipart representation of this MediaEntry.
     *
     * @return string|\ZendGData\MediaMimeStream The MIME multipart
     *         representation of this MediaEntry. If the entry consisted only
     *         of XML, a string is returned.
     */
    public function encode()
    {
        $xmlData = $this->saveXML();
        $mediaSource = $this->getMediaSource();
        if ($mediaSource === null) {
            // No attachment, just send XML for entry
            return $xmlData;
        } else {
            return new \ZendGData\MediaMimeStream($xmlData,
                $mediaSource->getFilename(), $mediaSource->getContentType());
        }
    }

    /**
     * Return the MediaSource object representing the file attached to this
     * MediaEntry.
     *
     * @return \ZendGData\App\MediaSource The attached MediaSource/file
     */
    public function getMediaSource()
    {
        return $this->_mediaSource;
    }

    /**
     * Set the MediaSource object (file) for this MediaEntry
     *
     * @param \ZendGData\App\MediaSource $value The attached MediaSource/file
     * @return \ZendGData\App\MediaEntry Provides a fluent interface
     */
    public function setMediaSource($value)
    {
        if ($value instanceof MediaSource) {
            $this->_mediaSource = $value;
        } else {
            throw new InvalidArgumentException(
                    'You must specify the media data as a class that conforms to \ZendGData\App\MediaSource.');
        }
        return $this;
    }

}
