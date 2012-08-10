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
class UserFeedTest extends \PHPUnit_Framework_TestCase
{
    protected $userFeed = null;

    /**
      * Called before each test to setup any fixtures.
      */
    public function setUp()
    {
        $userFeedText = file_get_contents(
                'ZendGData/GApps/_files/UserFeedDataSample1.xml',
                true);
        $this->userFeed = new GApps\UserFeed($userFeedText);
        $this->emptyUserFeed = new GApps\UserFeed();
    }

    public function testEmptyFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->emptyUserFeed->extensionElements));
        $this->assertTrue(count($this->emptyUserFeed->extensionElements) == 0);
    }

    public function testEmptyFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->emptyUserFeed->extensionAttributes));
        $this->assertTrue(count($this->emptyUserFeed->extensionAttributes) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->userFeed->extensionElements));
        $this->assertTrue(count($this->userFeed->extensionElements) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->userFeed->extensionAttributes));
        $this->assertTrue(count($this->userFeed->extensionAttributes) == 0);
    }

    /**
      * Convert sample feed to XML then back to objects. Ensure that
      * all objects are instances of EventEntry and object count matches.
      */
    public function testXmlImportAndOutputAreNonDestructive()
    {
        $entryCount = 0;
        foreach ($this->userFeed as $entry) {
            $entryCount++;
            $this->assertTrue($entry instanceof GApps\UserEntry);
        }
        $this->assertTrue($entryCount > 0);

        /* Grab XML from $this->userFeed and convert back to objects */
        $newUserFeed = new GApps\UserFeed(
                $this->userFeed->saveXML());
        $newEntryCount = 0;
        foreach ($newUserFeed as $entry) {
            $newEntryCount++;
            $this->assertTrue($entry instanceof GApps\UserEntry);
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
        foreach ($this->userFeed as $entry) {
            $entryCount++;
        }
        $this->assertEquals(2, $entryCount);
    }

}
