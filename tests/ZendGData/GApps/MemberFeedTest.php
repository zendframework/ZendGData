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

use ZendGData\GApps\MemberEntry;
use ZendGData\GApps\MemberFeed;

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class MemberFeedTest extends \PHPUnit_Framework_TestCase
{
    protected $memberFeed = null;

    /**
      * Called before each test to setup any fixtures.
      */
    public function setUp()
    {
        $memberFeedText = file_get_contents(
                'ZendGData/GApps/_files/MemberFeedDataSample1.xml',
                true);
        $this->memberFeed = new MemberFeed($memberFeedText);
        $this->emptyMemberFeed = new MemberFeed();
    }

    public function testEmptyFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->emptyMemberFeed->extensionElements));
        $this->assertTrue(count($this->emptyMemberFeed->extensionElements) == 0);
    }

    public function testEmptyFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->emptyMemberFeed->extensionAttributes));
        $this->assertTrue(count($this->emptyMemberFeed->extensionAttributes) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->memberFeed->extensionElements));
        $this->assertTrue(count($this->memberFeed->extensionElements) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->memberFeed->extensionAttributes));
        $this->assertTrue(count($this->memberFeed->extensionAttributes) == 0);
    }

    /**
      * Convert sample feed to XML then back to objects. Ensure that
      * all objects are instances of MemberEntry and object count matches.
      */
    public function testXmlImportAndOutputAreNonDestructive()
    {
        $entryCount = 0;
        foreach ($this->memberFeed as $entry) {
            $entryCount++;
            $this->assertTrue($entry instanceof MemberEntry);
        }
        $this->assertTrue($entryCount > 0);

        /* Grab XML from $this->memberFeed and convert back to objects */
        $newMemberFeed = new MemberFeed(
                $this->memberFeed->saveXML());
        $newEntryCount = 0;
        foreach ($newMemberFeed as $entry) {
            $newEntryCount++;
            $this->assertTrue($entry instanceof MemberEntry);
        }
        $this->assertEquals($entryCount, $newEntryCount);
    }

    /**
      * Ensure that there number of member entries equals the number
      * of members defined in the sample file.
      */
    public function testAllEntriesInFeedAreInstantiated()
    {
        //TODO feeds implementing ArrayAccess would be helpful here
        $entryCount = 0;
        foreach ($this->memberFeed as $entry) {
            $entryCount++;
        }
        $this->assertEquals(2, $entryCount);
    }

}
