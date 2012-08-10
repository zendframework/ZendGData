<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Media\Extension;

/**
 * Represents the media:keywords element
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Media
 */
class MediaKeywords extends \ZendGData\Extension
{
    protected $_rootElement = 'keywords';
    protected $_rootNamespace = 'media';

    /**
     * Constructs a new MediaKeywords element
     */
    public function __construct()
    {
        $this->registerAllNamespaces(\ZendGData\Media::$namespaces);
        parent::__construct();
    }

}
