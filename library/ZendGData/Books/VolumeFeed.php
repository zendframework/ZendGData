<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Books;

use ZendGData\Books;

/**
 * Describes a Book Search volume feed
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Books
 */
class VolumeFeed extends \ZendGData\Feed
{

    /**
     * Constructor for ZendGData\Books\VolumeFeed which
     * Describes a Book Search volume feed
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Books::$namespaces);
        parent::__construct($element);
    }

     /**
      * The classname for individual feed elements.
      *
      * @var string
      */
     protected $_entryClassName = 'ZendGData\Books\VolumeEntry';

}

