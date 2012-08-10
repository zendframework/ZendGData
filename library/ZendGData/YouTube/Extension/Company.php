<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\YouTube\Extension;

/**
 * Represents the yt:company element
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage YouTube
 */
class Company extends \ZendGData\Extension
{

    protected $_rootElement = 'company';
    protected $_rootNamespace = 'yt';

    public function __construct($text = null)
    {
        $this->registerAllNamespaces(\ZendGData\YouTube::$namespaces);
        parent::__construct();
        $this->_text = $text;
    }

}
