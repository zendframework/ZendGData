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

use ZendGData\GApps\OwnerEntry;
use ZendGData\GApps\OwnerFeed;

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class OwnerFeedTest extends \PHPUnit_Framework_TestCase
{
    protected $ownerFeed = null;

    /**
      * Called before each test to setup any fixtures.
      */
    public function setUp()
    {
        $ownerFeedText = file_get_contents(
                'ZendGData/GApps/_files/OwnerFeedDataSample1.xml',
                true);
        $this->ownerFeed = new OwnerFeed($ownerFeedText);
        $this->emptyOwnerFeed = new OwnerFeed();
    }

    public function testEmptyFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->emptyOwnerFeed->extensionElements));
        $this->assertTrue(count($this->emptyOwnerFeed->extensionElements) == 0);
    }

    public function testEmptyFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->emptyOwnerFeed->extensionAttributes));
        $this->assertTrue(count($this->emptyOwnerFeed->extensionAttributes) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->ownerFeed->extensionElements));
        $this->assertTrue(count($this->ownerFeed->extensionElements) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->ownerFeed->extensionAttributes));
        $this->assertTrue(count($this->ownerFeed->extensionAttributes) == 0);
    }

    /**
      * Convert sample feed to XML then back to objects. Ensure that
      * all objects are instances of OwnerEntry and object count matches.
      */
    public function testXmlImportAndOutputAreNonDestructive()
    {
        $entryCount = 0;
        foreach ($this->ownerFeed as $entry) {
            $entryCount++;
            $this->assertTrue($entry instanceof OwnerEntry);
        }
        $this->assertTrue($entryCount > 0);

        /* Grab XML from $this->ownerFeed and convert back to objects */
        $newOwnerFeed = new OwnerFeed(
                $this->ownerFeed->saveXML());
        $newEntryCount = 0;
        foreach ($newOwnerFeed as $entry) {
            $newEntryCount++;
            $this->assertTrue($entry instanceof OwnerEntry);
        }
        $this->assertEquals($entryCount, $newEntryCount);
    }

    /**
      * Ensure that there number of owner entries equals the number
      * of owners defined in the sample file.
      */
    public function testAllEntriesInFeedAreInstantiated()
    {
        //TODO feeds implementing ArrayAccess would be helpful here
        $entryCount = 0;
        foreach ($this->ownerFeed as $entry) {
            $entryCount++;
        }
        $this->assertEquals(2, $entryCount);
    }

}
