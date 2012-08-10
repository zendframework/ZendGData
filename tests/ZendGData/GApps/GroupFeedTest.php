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

use ZendGData\GApps\GroupEntry;
use ZendGData\GApps\GroupFeed;

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class GroupFeedTest extends \PHPUnit_Framework_TestCase
{
    protected $groupFeed = null;

    /**
      * Called before each test to setup any fixtures.
      */
    public function setUp()
    {
        $groupFeedText = file_get_contents(
                'ZendGData/GApps/_files/GroupFeedDataSample1.xml',
                true);
        $this->groupFeed = new GroupFeed($groupFeedText);
        $this->emptyGroupFeed = new GroupFeed();
    }

    public function testEmptyFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->emptyGroupFeed->extensionElements));
        $this->assertTrue(count($this->emptyGroupFeed->extensionElements) == 0);
    }

    public function testEmptyFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->emptyGroupFeed->extensionAttributes));
        $this->assertTrue(count($this->emptyGroupFeed->extensionAttributes) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->groupFeed->extensionElements));
        $this->assertTrue(count($this->groupFeed->extensionElements) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->groupFeed->extensionAttributes));
        $this->assertTrue(count($this->groupFeed->extensionAttributes) == 0);
    }

    /**
      * Convert sample feed to XML then back to objects. Ensure that
      * all objects are instances of GroupEntry and object count matches.
      */
    public function testXmlImportAndOutputAreNonDestructive()
    {
        $entryCount = 0;
        foreach ($this->groupFeed as $entry) {
            $entryCount++;
            $this->assertTrue($entry instanceof GroupEntry);
        }
        $this->assertTrue($entryCount > 0);

        /* Grab XML from $this->groupFeed and convert back to objects */
        $newGroupFeed = new GroupFeed(
                $this->groupFeed->saveXML());
        $newEntryCount = 0;
        foreach ($newGroupFeed as $entry) {
            $newEntryCount++;
            $this->assertTrue($entry instanceof GroupEntry);
        }
        $this->assertEquals($entryCount, $newEntryCount);
    }

    /**
      * Ensure that there number of group entries equals the number
      * of groups defined in the sample file.
      */
    public function testAllEntriesInFeedAreInstantiated()
    {
        //TODO feeds implementing ArrayAccess would be helpful here
        $entryCount = 0;
        foreach ($this->groupFeed as $entry) {
            $entryCount++;
        }
        $this->assertEquals(2, $entryCount);
    }

}
