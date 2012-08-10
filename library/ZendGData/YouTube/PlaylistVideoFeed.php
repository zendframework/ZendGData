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
 * The YouTube video playlist flavor of an Atom Feed with media support
 * Represents a list of videos contained in a playlist.  Each entry in this
 * feed represents an individual video.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class PlaylistVideoFeed extends \ZendGData\Media\Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\YouTube\PlaylistVideoEntry';

    /**
     * Creates a Play Video feed, representing a list of videos contained
     * within a single playlist.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(YouTube::$namespaces);
        parent::__construct($element);
    }

}
