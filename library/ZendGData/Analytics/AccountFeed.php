<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_GData
 */

namespace ZendGData\Analytics;

use ZendGData;

/**
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Analytics
 */
class AccountFeed extends ZendGData\Feed
{
    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\Analytics\AccountEntry';

    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'ZendGData\Analytics\AccountFeed';

    /**
     * @see ZendGData\Feed::__construct()
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(ZendGData\Analytics::$namespaces);
        parent::__construct($element);
    }
}
