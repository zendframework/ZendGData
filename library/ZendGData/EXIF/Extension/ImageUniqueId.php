<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\EXIF\Extension;

/**
 * Represents the exif:imageUniqueId element used by the GData EXIF extensions.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage EXIF
 */
class ImageUniqueId extends \ZendGData\Extension
{

    protected $_rootNamespace = 'exif';
    protected $_rootElement = 'imageUniqueID';

    /**
     * Constructs a new ZendGData\EXIF\Extension\ImageUniqueId object.
     *
     * @param string $text (optional) The value to use for this element.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(\ZendGData\EXIF::$namespaces);
        parent::__construct();
        $this->setText($text);
    }

}
