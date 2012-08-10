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
class EmailListFeedTest extends \PHPUnit_Framework_TestCase
{
    protected $emailListFeed = null;

    /**
      * Called before each test to setup any fixtures.
      */
    public function setUp()
    {
        $emailListFeedText = file_get_contents(
                'ZendGData/GApps/_files/EmailListFeedDataSample1.xml',
                true);
        $this->emailListFeed = new GApps\EmailListFeed($emailListFeedText);
        $this->emptyEmailListFeed = new GApps\EmailListFeed();
    }

    public function testEmptyFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->emptyEmailListFeed->extensionElements));
        $this->assertTrue(count($this->emptyEmailListFeed->extensionElements) == 0);
    }

    public function testEmptyFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->emptyEmailListFeed->extensionAttributes));
        $this->assertTrue(count($this->emptyEmailListFeed->extensionAttributes) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->emailListFeed->extensionElements));
        $this->assertTrue(count($this->emailListFeed->extensionElements) == 0);
    }

    public function testSampleFeedShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->emailListFeed->extensionAttributes));
        $this->assertTrue(count($this->emailListFeed->extensionAttributes) == 0);
    }

    /**
      * Convert sample feed to XML then back to objects. Ensure that
      * all objects are instances of EventEntry and object count matches.
      */
    public function testXmlImportAndOutputAreNonDestructive()
    {
        $entryCount = 0;
        foreach ($this->emailListFeed as $entry) {
            $entryCount++;
            $this->assertTrue($entry instanceof GApps\EmailListEntry);
        }
        $this->assertTrue($entryCount > 0);

        /* Grab XML from $this->emailListFeed and convert back to objects */
        $newEmailListFeed = new GApps\EmailListFeed(
                $this->emailListFeed->saveXML());
        $newEntryCount = 0;
        foreach ($newEmailListFeed as $entry) {
            $newEntryCount++;
            $this->assertTrue($entry instanceof GApps\EmailListEntry);
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
        foreach ($this->emailListFeed as $entry) {
            $entryCount++;
        }
        $this->assertEquals(2, $entryCount);
    }

}
