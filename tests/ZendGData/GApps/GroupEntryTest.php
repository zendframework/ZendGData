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

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class GroupEntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->entryText = file_get_contents(
                'ZendGData/GApps/_files/GroupEntryDataSample1.xml',
                true);
        $this->entry = new GroupEntry();
    }

    private function verifyAllSamplePropertiesAreCorrect ($groupEntry)
    {
        $this->assertEquals('https://www.google.com/a/feeds/group/2.0/example.com/us-sales',
            $groupEntry->id->text);
        $this->assertEquals('1970-01-01T00:00:00.000Z', $groupEntry->updated->text);
        $this->assertEquals('self', $groupEntry->getLink('self')->rel);
        $this->assertEquals('application/atom+xml', $groupEntry->getLink('self')->type);
        $this->assertEquals('https://www.google.com/a/feeds/group/2.0/example.com/us-sales', $groupEntry->getLink('self')->href);
        $this->assertEquals('edit', $groupEntry->getLink('edit')->rel);
        $this->assertEquals('application/atom+xml', $groupEntry->getLink('edit')->type);
        $this->assertEquals('https://www.google.com/a/feeds/group/2.0/example.com/us-sales', $groupEntry->getLink('edit')->href);
        $this->assertEquals('groupId', $groupEntry->property[0]->name);
        $this->assertEquals('us-sales', $groupEntry->property[0]->value);
        $this->assertEquals('groupName', $groupEntry->property[1]->name);
        $this->assertEquals('us-sales', $groupEntry->property[1]->value);
        $this->assertEquals('description', $groupEntry->property[2]->name);
        $this->assertEquals('UnitedStatesSalesTeam', $groupEntry->property[2]->value);
        $this->assertEquals('emailPermission', $groupEntry->property[3]->name);
        $this->assertEquals('Domain', $groupEntry->property[3]->value);
    }

    public function testEmptyEntryShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->entry->extensionElements));
        $this->assertTrue(count($this->entry->extensionElements) == 0);
    }

    public function testEmptyEntryShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->entry->extensionAttributes));
        $this->assertTrue(count($this->entry->extensionAttributes) == 0);
    }

    public function testSampleEntryShouldHaveNoExtensionElements()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->assertTrue(is_array($this->entry->extensionElements));
        $this->assertTrue(count($this->entry->extensionElements) == 0);
    }

    public function testSampleEntryShouldHaveNoExtensionAttributes()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->assertTrue(is_array($this->entry->extensionAttributes));
        $this->assertTrue(count($this->entry->extensionAttributes) == 0);
    }

    public function testEmptyGroupEntryToAndFromStringShouldMatch()
    {
        $entryXml = $this->entry->saveXML();
        $newGroupEntry = new GroupEntry();
        $newGroupEntry->transferFromXML($entryXml);
        $newGroupEntryXml = $newGroupEntry->saveXML();
        $this->assertTrue($entryXml == $newGroupEntryXml);
    }

    public function testSamplePropertiesAreCorrect ()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->verifyAllSamplePropertiesAreCorrect($this->entry);
    }

    public function testConvertGroupEntryToAndFromString()
    {
        $this->entry->transferFromXML($this->entryText);
        $entryXml = $this->entry->saveXML();
        $newGroupEntry = new GroupEntry();
        $newGroupEntry->transferFromXML($entryXml);
        $this->verifyAllSamplePropertiesAreCorrect($newGroupEntry);
        $newGroupEntryXml = $newGroupEntry->saveXML();
        $this->assertEquals($entryXml, $newGroupEntryXml);
    }

}
