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
class EmailListRecipientEntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->entryText = file_get_contents(
                'ZendGData/GApps/_files/EmailListRecipientEntryDataSample1.xml',
                true);
        $this->entry = new GApps\EmailListRecipientEntry();
    }

    private function verifyAllSamplePropertiesAreCorrect ($emailListRecipientEntry)
    {
        $this->assertEquals('https://apps-apis.google.com/a/feeds/example.com/emailList/2.0/us-sales/recipient/SusanJones%40example.com',
            $emailListRecipientEntry->id->text);
        $this->assertEquals('1970-01-01T00:00:00.000Z', $emailListRecipientEntry->updated->text);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $emailListRecipientEntry->category[0]->scheme);
        $this->assertEquals('http://schemas.google.com/apps/2006#emailList.recipient', $emailListRecipientEntry->category[0]->term);
        $this->assertEquals('text', $emailListRecipientEntry->title->type);
        $this->assertEquals('SusanJones', $emailListRecipientEntry->title->text);
        $this->assertEquals('self', $emailListRecipientEntry->getLink('self')->rel);
        $this->assertEquals('application/atom+xml', $emailListRecipientEntry->getLink('self')->type);
        $this->assertEquals('https://apps-apis.google.com/a/feeds/example.com/emailList/2.0/us-sales/recipient/SusanJones%40example.com', $emailListRecipientEntry->getLink('self')->href);
        $this->assertEquals('edit', $emailListRecipientEntry->getLink('edit')->rel);
        $this->assertEquals('application/atom+xml', $emailListRecipientEntry->getLink('edit')->type);
        $this->assertEquals('https://apps-apis.google.com/a/feeds/example.com/emailList/2.0/us-sales/recipient/SusanJones%40example.com', $emailListRecipientEntry->getLink('edit')->href);
        $this->assertEquals('SusanJones@example.com', $emailListRecipientEntry->who->email);
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

    public function testEmptyEmailListRecipientEntryToAndFromStringShouldMatch()
    {
        $entryXml = $this->entry->saveXML();
        $newEmailListRecipientEntry = new GApps\EmailListRecipientEntry();
        $newEmailListRecipientEntry->transferFromXML($entryXml);
        $newEmailListRecipientEntryXml = $newEmailListRecipientEntry->saveXML();
        $this->assertTrue($entryXml == $newEmailListRecipientEntryXml);
    }

    public function testSamplePropertiesAreCorrect ()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->verifyAllSamplePropertiesAreCorrect($this->entry);
    }

    public function testConvertEmailListRecipientEntryToAndFromString()
    {
        $this->entry->transferFromXML($this->entryText);
        $entryXml = $this->entry->saveXML();
        $newEmailListRecipientEntry = new GApps\EmailListRecipientEntry();
        $newEmailListRecipientEntry->transferFromXML($entryXml);
        $this->verifyAllSamplePropertiesAreCorrect($newEmailListRecipientEntry);
        $newEmailListRecipientEntryXml = $newEmailListRecipientEntry->saveXML();
        $this->assertEquals($entryXml, $newEmailListRecipientEntryXml);
    }

}
