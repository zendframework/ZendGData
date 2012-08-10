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
class WorksheetFeed extends \ZendGData\Feed
{

    /**
     * Constructs a new ZendGData\Spreadsheets\WorksheetFeed object.
     * @param DOMElement $element (optional) The DOMElement on whick to base this element.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Spreadsheets::$namespaces);
        parent::__construct($element);
    }

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'ZendGData\Spreadsheets\WorksheetEntry';

    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'ZendGData\Spreadsheets\WorksheetFeed';

}
