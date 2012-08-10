<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\App\Extension;

/**
 * Represents the app:edited element
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage App
 */
class Edited extends AbstractExtension
{

    protected $_rootElement = 'edited';

    public function __construct($text = null)
    {
        parent::__construct();
        $this->_text = $text;
    }

}
