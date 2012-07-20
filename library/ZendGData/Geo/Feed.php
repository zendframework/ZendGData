<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_GData
 */

namespace ZendGData\Geo;

use ZendGData\Geo;

/**
 * Feed for Gdata Geographic data entries.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Geo
 */
class Feed extends \ZendGData\Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\Geo\Entry';

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Geo::$namespaces);
        parent::__construct($element);
    }

}
