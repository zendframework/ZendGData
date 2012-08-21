<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Spreadsheets;

use ZendGData\Spreadsheets;

/**
 * @category   Zend
 * @package    ZendGData\Spreadsheets
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Spreadsheets
 */
class WorksheetEntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->wksEntry = new Spreadsheets\WorksheetEntry();
    }

    public function testToAndFromString()
    {
        $this->wksEntry->setRowCount(new \ZendGData\Spreadsheets\Extension\RowCount('20'));
        $this->assertTrue($this->wksEntry->getRowCount()->getText() == '20');
        $this->wksEntry->setColumnCount(new \ZendGData\Spreadsheets\Extension\ColCount('40'));
        $this->assertTrue($this->wksEntry->getColumnCount()->getText() == '40');
        $newWksEntry = new Spreadsheets\WorksheetEntry();
        $doc = new \DOMDocument();
        $doc->loadXML($this->wksEntry->saveXML());
        $newWksEntry->transferFromDom($doc->documentElement);
        $this->assertTrue($this->wksEntry->getRowCount()->getText() == $newWksEntry->getRowCount()->getText());
        $this->assertTrue($this->wksEntry->getColumnCount()->getText() == $newWksEntry->getColumnCount()->getText());
    }

}
