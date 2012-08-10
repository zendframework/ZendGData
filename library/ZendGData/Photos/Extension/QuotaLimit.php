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
 * Represents the gphoto:quotaLimit element used by the API.
 * This class represents the number of bytes of storage available for
 * a user.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Photos
 */
class QuotaLimit extends \ZendGData\Extension
{

    protected $_rootNamespace = 'gphoto';
    protected $_rootElement = 'quotaLimit';

    /**
     * Constructs a new ZendGData\Photos\Extension\QuotaLimit object.
     *
     * @param string $text (optional) The value being represented.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(\ZendGData\Photos::$namespaces);
        parent::__construct();
        $this->setText($text);
    }

}
