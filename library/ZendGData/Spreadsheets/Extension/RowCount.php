<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Spreadsheets\Extension;

/**
 * Concrete class for working with RowCount elements.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Spreadsheets
 */
class RowCount extends \ZendGData\Extension
{

    protected $_rootElement = 'rowCount';
    protected $_rootNamespace = 'gs';

    /**
     * Constructs a new ZendGData\Spreadsheets\Extension\RowCount object.
     * @param string $text (optional) The text content of the element.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(\ZendGData\Spreadsheets::$namespaces);
        parent::__construct();
        $this->_text = $text;
    }

}
