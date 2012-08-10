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

/**
 * @category   Zend
 * @package    ZendGData\Spreadsheets
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Spreadsheets
 */
class ListQueryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->docQuery = new \ZendGData\Spreadsheets\ListQuery();
    }

    public function testWorksheetId()
    {
        $this->assertTrue($this->docQuery->getWorksheetId() == 'default');
        $this->docQuery->setWorksheetId('123');
        $this->assertTrue($this->docQuery->getWorksheetId() == '123');
    }

    public function testSpreadsheetKey()
    {
        $this->assertTrue($this->docQuery->getSpreadsheetKey() == null);
        $this->docQuery->setSpreadsheetKey('abc');
        $this->assertTrue($this->docQuery->getSpreadsheetKey() == 'abc');
    }

    public function testRowId()
    {
        $this->assertTrue($this->docQuery->getRowId() == null);
        $this->docQuery->setRowId('xyz');
        $this->assertTrue($this->docQuery->getRowId() == 'xyz');
    }

    public function testProjection()
    {
        $this->assertTrue($this->docQuery->getProjection() == 'full');
        $this->docQuery->setProjection('abc');
        $this->assertTrue($this->docQuery->getProjection() == 'abc');
    }

    public function testVisibility()
    {
        $this->assertTrue($this->docQuery->getVisibility() == 'private');
        $this->docQuery->setVisibility('xyz');
        $this->assertTrue($this->docQuery->getVisibility() == 'xyz');
    }

    public function testSpreadsheetQuery()
    {
        $this->assertTrue($this->docQuery->getSpreadsheetQuery() == null);
        $this->docQuery->setSpreadsheetQuery('first=john&last=smith');
        $this->assertTrue($this->docQuery->getSpreadsheetQuery() == 'first=john&last=smith');
        $this->assertTrue($this->docQuery->getQueryString() == '?sq=first%3Djohn%26last%3Dsmith');
        $this->docQuery->setSpreadsheetQuery(null);
        $this->assertTrue($this->docQuery->getSpreadsheetQuery() == null);
    }


    public function testOrderBy()
    {
        $this->assertTrue($this->docQuery->getOrderBy() == null);
        $this->docQuery->setOrderBy('column:first');
        $this->assertTrue($this->docQuery->getOrderBy() == 'column:first');
        $this->assertTrue($this->docQuery->getQueryString() == '?orderby=column%3Afirst');
        $this->docQuery->setOrderBy(null);
        $this->assertTrue($this->docQuery->getOrderBy() == null);
    }

    public function testReverse()
    {
        $this->assertTrue($this->docQuery->getReverse() == null);
        $this->docQuery->setReverse('true');
        $this->assertTrue($this->docQuery->getReverse() == 'true');
        $this->assertTrue($this->docQuery->getQueryString() == '?reverse=true');
        $this->docQuery->setReverse(null);
        $this->assertTrue($this->docQuery->getReverse() == null);
    }

}
