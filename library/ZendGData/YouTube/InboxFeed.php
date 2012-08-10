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
 * The YouTube inbox feed list flavor of an Atom Feed with media support
 * Represents a list of individual inbox entries, where each contained entry is
 * a message.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class InboxFeed extends \ZendGData\Media\Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\YouTube\InboxEntry';

    /**
     * Creates an Inbox feed, representing a list of messages,
     * associated with an individual user.
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
