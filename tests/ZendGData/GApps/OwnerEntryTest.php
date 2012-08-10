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

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class OwnerEntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->entryText = file_get_contents(
                'ZendGData/GApps/_files/OwnerEntryDataSample1.xml',
                true);
        $this->entry = new OwnerEntry();
    }

    private function verifyAllSamplePropertiesAreCorrect ($ownerEntry)
    {
        $this->assertEquals('https://www.google.com/a/feeds/group/2.0/example.com/us-sales/owner/joe%40example.com',
            $ownerEntry->id->text);
        $this->assertEquals('1970-01-01T00:00:00.000Z', $ownerEntry->updated->text);
        $this->assertEquals('self', $ownerEntry->getLink('self')->rel);
        $this->assertEquals('application/atom+xml', $ownerEntry->getLink('self')->type);
        $this->assertEquals('https://www.google.com/a/feeds/group/2.0/example.com/us-sales/owner/joe%40example.com', $ownerEntry->getLink('self')->href);
        $this->assertEquals('edit', $ownerEntry->getLink('edit')->rel);
        $this->assertEquals('application/atom+xml', $ownerEntry->getLink('edit')->type);
        $this->assertEquals('https://www.google.com/a/feeds/group/2.0/example.com/us-sales/owner/joe%40example.com', $ownerEntry->getLink('edit')->href);
        $this->assertEquals('email', $ownerEntry->property[0]->name);
        $this->assertEquals('joe@example.com', $ownerEntry->property[0]->value);
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

    public function testEmptyOwnerEntryToAndFromStringShouldMatch()
    {
        $entryXml = $this->entry->saveXML();
        $newOwnerEntry = new OwnerEntry();
        $newOwnerEntry->transferFromXML($entryXml);
        $newOwnerEntryXml = $newOwnerEntry->saveXML();
        $this->assertTrue($entryXml == $newOwnerEntryXml);
    }

    public function testSamplePropertiesAreCorrect ()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->verifyAllSamplePropertiesAreCorrect($this->entry);
    }

    public function testConvertOwnerEntryToAndFromString()
    {
        $this->entry->transferFromXML($this->entryText);
        $entryXml = $this->entry->saveXML();
        $newOwnerEntry = new OwnerEntry();
        $newOwnerEntry->transferFromXML($entryXml);
        $this->verifyAllSamplePropertiesAreCorrect($newOwnerEntry);
        $newOwnerEntryXml = $newOwnerEntry->saveXML();
        $this->assertEquals($entryXml, $newOwnerEntryXml);
    }

}
