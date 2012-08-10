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
class SpreadsheetFeedTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->sprFeed = new Spreadsheets\SpreadsheetFeed(
                file_get_contents(__DIR__ . '/_files/TestDataSpreadsheetFeedSample1.xml'),
                true);
    }

    public function testToAndFromString()
    {
        $this->assertTrue(count($this->sprFeed->entries) == 1);
        foreach($this->sprFeed->entries as $entry) {
            $this->assertTrue($entry instanceof Spreadsheets\SpreadsheetEntry);
        }

        $newSprFeed = new Spreadsheets\SpreadsheetFeed();
        $doc = new \DOMDocument();
        $doc->loadXML($this->sprFeed->saveXML());
        $newSprFeed->transferFromDom($doc->documentElement);

        $this->assertTrue(count($newSprFeed->entries) == 1);
        foreach($newSprFeed->entries as $entry) {
            $this->assertTrue($entry instanceof Spreadsheets\SpreadsheetEntry);
        }
    }

}
