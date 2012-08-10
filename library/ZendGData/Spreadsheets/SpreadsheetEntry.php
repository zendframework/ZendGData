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
 * Concrete class for working with Atom entries.
 *
 * @category   Zend
 * @package    ZendGData
 * @subpackage Spreadsheets
 */
class SpreadsheetEntry extends \ZendGData\Entry
{

    protected $_entryClassName = 'ZendGData\Spreadsheets\SpreadsheetEntry';

    /**
     * Constructs a new ZendGData\Spreadsheets\SpreadsheetEntry object.
     * @param DOMElement $element (optional) The DOMElement on which to base this object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Spreadsheets::$namespaces);
        parent::__construct($element);
    }

    /**
     * Returns the worksheets in this spreadsheet
     *
     * @return \ZendGData\Spreadsheets\WorksheetFeed The worksheets
     */
    public function getWorksheets()
    {
        $service = new Spreadsheets($this->getService()->getHttpClient());
        return $service->getWorksheetFeed($this);
    }

}
