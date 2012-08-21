<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Geo;

use ZendGData\Geo;

/**
 * Feed for GData Geographic data entries.
 *
 * @category   Zend
 * @package    ZendGData
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
