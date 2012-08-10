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
 * The YouTube comments flavor of an Atom Feed
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class CommentFeed extends \ZendGData\Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\YouTube\CommentEntry';

    /**
     * Constructs a new YouTube Comment Feed object, to represent
     * a feed of comments for an individual video
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
