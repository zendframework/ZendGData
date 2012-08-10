<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Geo\Extension;

/**
 * Represents the gml:pos element used by the GData Geo extensions.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Geo
 */
class GmlPos extends \ZendGData\Extension
{

    protected $_rootNamespace = 'gml';
    protected $_rootElement = 'pos';

    /**
     * Constructs a new ZendGData\Geo\Extension\GmlPos object.
     *
     * @param string $text (optional) The value to use for this element.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(\ZendGData\Geo::$namespaces);
        parent::__construct();
        $this->setText($text);
    }

}
