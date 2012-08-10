<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGData\Spreadsheets;

use ZendGData\Spreadsheets;

/**
 * @category   Zend
 * @package    ZendGData
 * @subpackage Spreadsheets
 */
class ListFeed extends \ZendGData\Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\Spreadsheets\ListEntry';

    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'ZendGData\Spreadsheets\ListFeed';

    /**
     * Constructs a new ZendGData\Spreadsheets\ListFeed object.
     * @param DOMElement $element An existing XML element on which to base this new object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Spreadsheets::$namespaces);
        parent::__construct($element);
    }

}
