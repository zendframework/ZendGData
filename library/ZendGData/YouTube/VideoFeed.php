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
 * The YouTube video flavor of an Atom Feed with media support
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class VideoFeed extends \ZendGData\Media\Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\YouTube\VideoEntry';

    /**
     * Creates a Video feed, representing a list of videos
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
