<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Extension;

use ZendGData\Extension;

/**
 * Represents the openSearch:totalResults element
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage GData
 */
class OpenSearchTotalResults extends Extension
{

    protected $_rootElement = 'totalResults';
    protected $_rootNamespace = 'openSearch';

    public function __construct($text = null)
    {
        parent::__construct();
        $this->_text = $text;
    }

}
