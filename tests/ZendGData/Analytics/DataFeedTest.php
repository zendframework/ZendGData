<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_GData
 */

namespace ZendGDataTest\Analytics;

use ZendGData\Analytics\DataEntry;
use ZendGData\Analytics\DataFeed;
use ZendGData\Analytics\DataQuery;

/**
 * @category   Zend
 * @package    Zend_Gdata_Analytics
 * @subpackage UnitTests
 * @group      ZendGdata
 * @group      ZendGdata_Analytics
 */
class DataFeedTest extends \PHPUnit_Framework_TestCase
{
    public $testData = array(
        'foobarbaz.de' => 12,
        'foobar.de' => 3,
        'foobarbaz.ch' => 1,
        'baz.ch' => 1,
    );
    /** @var DataFeed */
    public $dataFeed;

    public function setUp()
    {
        $this->dataFeed = new DataFeed(
            file_get_contents(dirname(__FILE__) . '/_files/TestDataFeed.xml')
        );
    }

    public function testDataFeed()
    {
        $count = count($this->testData);
        $this->assertEquals(count($this->dataFeed->entries), $count);
        $this->assertEquals($this->dataFeed->entries->count(), $count);
        foreach ($this->dataFeed->entries as $entry) {
            $this->assertTrue($entry instanceof DataEntry);
        }
    }

    public function testGetters()
    {
        $sources = array_keys($this->testData);
        $values = array_values($this->testData);

        foreach ($this->dataFeed as $index => $row) {
            $source = $row->getDimension(DataQuery::DIMENSION_SOURCE);
            $medium = $row->getDimension('ga:medium');
            $visits = $row->getMetric('ga:visits');
            $visitsValue = $row->getValue('ga:visits');

            $this->assertEquals("$medium", 'referral');
            $this->assertEquals("$source", $sources[$index]);
            $this->assertEquals("$visits", $values[$index]);
            $this->assertEquals("$visitsValue", $values[$index]);
        }
    }
}
