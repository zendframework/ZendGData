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
 * Represents the gphoto:commentCount element used by the API. This
 * class represents the number of comments attached to an entry and is usually contained
 * within an instance of ZendGData\Photos\PhotoEntry or AlbumEntry.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Photos
 */
class CommentCount extends \ZendGData\Extension
{

    protected $_rootNamespace = 'gphoto';
    protected $_rootElement = 'commentCount';

    /**
     * Constructs a new ZendGData\Photos\Extension\CommentCount object.
     *
     * @param string $text (optional) The value to use for the count.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(\ZendGData\Photos::$namespaces);
        parent::__construct();
        $this->setText($text);
    }

}
