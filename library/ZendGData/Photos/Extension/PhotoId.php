<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Photos\Extension;

/**
 * Represents the gphoto:id element used by the Picasa API.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Photos
 */
class PhotoId extends \ZendGData\Extension
{

    protected $_rootNamespace = 'gphoto';
    protected $_rootElement = 'id';

    /**
     * Constructs a new ZendGData\Photos\Extension\PhotoId object.
     *
     * @param string $text (optional) The value to represent.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(\ZendGData\Photos::$namespaces);
        parent::__construct();
        $this->setText($text);
    }

}
