<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\GApps;

use ZendGData\GApps;

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class NicknameFeedTest extends \PHPUnit_Framework_TestCase
{
    protected $nicknameFeed = null;

    /**
      * Called before each test to setup any fixtures.
      */
    public function setUp()
    {
        $nicknameFeedText = file_get_contents(
                'ZendGData/GApps/_files/NicknameFeedDataSample1.xml',
                true);
        $this->nicknameFeed = new GApps\NicknameFeed($nicknameFeedText);
        $this->emptyNicknameFeed = new GApps\NicknameFeed();
    }

    public function testEmptyFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->emptyNicknameFeed->extensionElements));
        $this->assertTrue(count($this->emptyNicknameFeed->extensionElements) == 0);
    }

    public function testEmptyFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->emptyNicknameFeed->extensionAttributes));
        $this->assertTrue(count($this->emptyNicknameFeed->extensionAttributes) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->nicknameFeed->extensionElements));
        $this->assertTrue(count($this->nicknameFeed->extensionElements) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->nicknameFeed->extensionAttributes));
        $this->assertTrue(count($this->nicknameFeed->extensionAttributes) == 0);
    }

    /**
      * Convert sample feed to XML then back to objects. Ensure that
      * all objects are instances of EventEntry and object count matches.
      */
    public function testXmlImportAndOutputAreNonDestructive()
    {
        $entryCount = 0;
        foreach ($this->nicknameFeed as $entry) {
            $entryCount++;
            $this->assertTrue($entry instanceof GApps\NicknameEntry);
        }
        $this->assertTrue($entryCount > 0);

        /* Grab XML from $this->nicknameFeed and convert back to objects */
        $newNicknameFeed = new GApps\NicknameFeed(
                $this->nicknameFeed->saveXML());
        $newEntryCount = 0;
        foreach ($newNicknameFeed as $entry) {
            $newEntryCount++;
            $this->assertTrue($entry instanceof GApps\NicknameEntry);
        }
        $this->assertEquals($entryCount, $newEntryCount);
    }

    /**
      * Ensure that there number of lsit feeds equals the number
      * of calendars defined in the sample file.
      */
    public function testAllEntriesInFeedAreInstantiated()
    {
        //TODO feeds implementing ArrayAccess would be helpful here
        $entryCount = 0;
        foreach ($this->nicknameFeed as $entry) {
            $entryCount++;
        }
        $this->assertEquals(2, $entryCount);
    }

}
