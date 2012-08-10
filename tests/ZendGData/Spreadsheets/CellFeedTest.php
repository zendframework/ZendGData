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
use ZendGData\Spreadsheets\Extension;

/**
 * @category   Zend
 * @package    ZendGData\Spreadsheets
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Spreadsheets
 */
class CellFeedTest extends \PHPUnit_Framework_TestCase
{

    public $cellFeed;

    public function setUp()
    {
        $this->cellFeed = new Spreadsheets\CellFeed(
                file_get_contents('ZendGData/Spreadsheets/_files/TestDataCellFeedSample1.xml', true),
                true);
    }

    public function testToAndFromString()
    {
        $this->assertEquals(2, count($this->cellFeed->entries));
        $this->assertEquals(2, $this->cellFeed->entries->count());
        foreach($this->cellFeed->entries as $entry) {
            $this->assertInstanceOf('ZendGData\Spreadsheets\CellEntry', $entry);
        }
        $this->assertInstanceOf('ZendGData\Spreadsheets\Extension\RowCount',
                                $this->cellFeed->getRowCount());
        $this->assertTrue($this->cellFeed->getRowCount()->getText() == '100');
        $this->assertInstanceOf('ZendGData\Spreadsheets\Extension\ColCount',
                                $this->cellFeed->getColumnCount());
        $this->assertTrue($this->cellFeed->getColumnCount()->getText() == '20');

        $newCellFeed = new Spreadsheets\CellFeed();
        $doc = new \DOMDocument();
        $doc->loadXML($this->cellFeed->saveXML());
        $newCellFeed->transferFromDom($doc->documentElement);

        $this->assertEquals(2, count($newCellFeed->entries));
        $this->assertEquals(2, $newCellFeed->entries->count());
        foreach($newCellFeed->entries as $entry) {
            $this->assertInstanceOf('ZendGData\Spreadsheets\CellEntry', $entry);
        }
        $this->assertInstanceOf('ZendGData\Spreadsheets\Extension\RowCount',
                                $newCellFeed->getRowCount());
        $this->assertTrue($newCellFeed->getRowCount()->getText() == '100');
        $this->assertInstanceOf('ZendGData\Spreadsheets\Extension\ColCount',
                                $newCellFeed->getColumnCount());
        $this->assertTrue($newCellFeed->getColumnCount()->getText() == '20');
    }

    public function testGetSetCounts()
    {
        $newRowCount = new Extension\RowCount();
        $newRowCount->setText("20");
        $newColCount = new Extension\ColCount();
        $newColCount->setText("50");

        $this->cellFeed->setRowCount($newRowCount);
        $this->cellFeed->setColumnCount($newColCount);

        $this->assertTrue($this->cellFeed->getRowCount()->getText() == "20");
        $this->assertTrue($this->cellFeed->getColumnCount()->getText() == "50");
    }

}
