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
 * The YouTube comments flavor of an Atom Entry
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class CommentEntry extends \ZendGData\Entry
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\YouTube\CommentEntry';

    /**
     * Constructs a new ZendGData\YouTube\CommentEntry object.
     * @param DOMElement $element (optional) The DOMElement on which to
     * base this object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(YouTube::$namespaces);
        parent::__construct($element);
    }

}
