<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\YouTube;

use ZendGData\YouTube;

/**
 * @category   Zend
 * @package    ZendGData\YouTube
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\YouTube
 */
class ContactEntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->entryText = file_get_contents(
                'ZendGData/YouTube/_files/ContactEntryDataSample1.xml',
                true);
        $this->entry = new YouTube\ContactEntry();
    }

    private function verifyAllSamplePropertiesAreCorrect ($contactEntry)
    {
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic/contacts/testuser',
            $contactEntry->id->text);
        $this->assertEquals('2007-09-21T02:44:41.134Z', $contactEntry->updated->text);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $contactEntry->category[0]->scheme);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007#friend', $contactEntry->category[0]->term);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007/contact.cat', $contactEntry->category[1]->scheme);
        $this->assertEquals('Friends', $contactEntry->category[1]->term);
        $this->assertEquals('text', $contactEntry->title->type);
        $this->assertEquals('testuser', $contactEntry->title->text);
        $this->assertEquals('self', $contactEntry->getLink('self')->rel);
        $this->assertEquals('application/atom+xml', $contactEntry->getLink('self')->type);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic/contacts/testuser', $contactEntry->getLink('self')->href);
        $this->assertEquals('davidchoimusic', $contactEntry->author[0]->name->text);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic', $contactEntry->author[0]->uri->text);
        $this->assertEquals('testuser', $contactEntry->username->text);
        $this->assertEquals('accepted', $contactEntry->status->text);
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

    public function testEmptyContactEntryToAndFromStringShouldMatch()
    {
        $entryXml = $this->entry->saveXML();
        $newContactEntry = new YouTube\ContactEntry();
        $newContactEntry->transferFromXML($entryXml);
        $newContactEntryXml = $newContactEntry->saveXML();
        $this->assertTrue($entryXml == $newContactEntryXml);
    }

    public function testSamplePropertiesAreCorrect ()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->verifyAllSamplePropertiesAreCorrect($this->entry);
    }

    public function testConvertContactEntryToAndFromString()
    {
        $this->entry->transferFromXML($this->entryText);
        $entryXml = $this->entry->saveXML();
        $newContactEntry = new YouTube\ContactEntry();
        $newContactEntry->transferFromXML($entryXml);
        $this->verifyAllSamplePropertiesAreCorrect($newContactEntry);
        $newContactEntryXml = $newContactEntry->saveXML();
        $this->assertEquals($entryXml, $newContactEntryXml);
    }

}
