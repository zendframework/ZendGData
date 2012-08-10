<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\EXIF;

use ZendGData\EXIF;

/**
 * Feed for GData EXIF data entries.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage EXIF
 */
class Feed extends \ZendGData\Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = '\ZendGData\EXIF\Entry';

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(EXIF::$namespaces);
        parent::__construct($element);
    }

}
