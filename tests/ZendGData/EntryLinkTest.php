<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest;

use ZendGData\Extension;

/**
 * @category   Zend
 * @package    ZendGData
 * @subpackage UnitTests
 * @group      ZendGData
 */
class EntryLinkTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->entryLinkText = file_get_contents(
                'ZendGData/_files/EntryLinkElementSample1.xml',
                true);
        $this->entryLink = new Extension\EntryLink();
    }

    public function testEmptyEntryLinkShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->entryLink->extensionElements));
        $this->assertTrue(count($this->entryLink->extensionElements) == 0);
    }

    public function testEmptyEntryLinkShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->entryLink->extensionAttributes));
        $this->assertTrue(count($this->entryLink->extensionAttributes) == 0);
    }

    public function testSampleEntryLinkShouldHaveNoExtensionElements()
    {
        $this->entryLink->transferFromXML($this->entryLinkText);
        $this->assertTrue(is_array($this->entryLink->extensionElements));
        $this->assertTrue(count($this->entryLink->extensionElements) == 0);
    }

    public function testSampleEntryLinkShouldHaveNoExtensionAttributes()
    {
        $this->entryLink->transferFromXML($this->entryLinkText);
        $this->assertTrue(is_array($this->entryLink->extensionAttributes));
        $this->assertTrue(count($this->entryLink->extensionAttributes) == 0);
    }

    public function testNormalEntryLinkShouldHaveNoExtensionElements()
    {
        $this->entryLink->href = "http://gmail.com/jo/contacts/Bob";
        $this->entryLink->rel = "self";
        $this->entryLink->readOnly = "false";

        $this->assertEquals("http://gmail.com/jo/contacts/Bob", $this->entryLink->href);
        $this->assertEquals("self", $this->entryLink->rel);
        $this->assertEquals("false", $this->entryLink->readOnly);

        $this->assertEquals(0, count($this->entryLink->extensionElements));
        $newEntryLink = new Extension\EntryLink();
        $newEntryLink->transferFromXML($this->entryLink->saveXML());
        $this->assertEquals(0, count($newEntryLink->extensionElements));
        $newEntryLink->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(1, count($newEntryLink->extensionElements));
        $this->assertEquals("http://gmail.com/jo/contacts/Bob", $newEntryLink->href);
        $this->assertEquals("self", $newEntryLink->rel);
        $this->assertTrue($newEntryLink->readOnly);

        /* try constructing using magic factory */
        $gdata = new \ZendGData\GData();
        $newEntryLink2 = $gdata->newEntryLink();
        $newEntryLink2->transferFromXML($newEntryLink->saveXML());
        $this->assertEquals(1, count($newEntryLink2->extensionElements));
        $this->assertEquals("http://gmail.com/jo/contacts/Bob", $newEntryLink2->href);
        $this->assertEquals("self", $newEntryLink2->rel);
        $this->assertTrue($newEntryLink2->readOnly);
    }

    public function testEmptyEntryLinkToAndFromStringShouldMatch()
    {
        $entryLinkXml = $this->entryLink->saveXML();
        $newEntryLink = new Extension\EntryLink();
        $newEntryLink->transferFromXML($entryLinkXml);
        $newEntryLinkXml = $newEntryLink->saveXML();
        $this->assertTrue($entryLinkXml == $newEntryLinkXml);
    }

    public function testEntryLinkWithValueToAndFromStringShouldMatch()
    {
        $this->entryLink->href = "http://gmail.com/jo/contacts/Bob";
        $this->entryLink->rel = "self";
        $this->entryLink->readOnly = "false";
        $entryLinkXml = $this->entryLink->saveXML();
        $newEntryLink = new Extension\EntryLink();
        $newEntryLink->transferFromXML($entryLinkXml);
        $newEntryLinkXml = $newEntryLink->saveXML();
        $this->assertTrue($entryLinkXml == $newEntryLinkXml);
        $this->assertEquals("http://gmail.com/jo/contacts/Bob", $this->entryLink->href);
        $this->assertEquals("self", $this->entryLink->rel);
        $this->assertEquals("false", $this->entryLink->readOnly);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->entryLink->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->entryLink->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->entryLink->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->entryLink->extensionAttributes['foo2']['value']);
        $entryLinkXml = $this->entryLink->saveXML();
        $newEntryLink = new Extension\EntryLink();
        $newEntryLink->transferFromXML($entryLinkXml);
        $this->assertEquals('bar', $newEntryLink->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newEntryLink->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullEntryLinkToAndFromString()
    {
        $this->entryLink->transferFromXML($this->entryLinkText);
        $this->assertEquals("http://gmail.com/jo/contacts/Jo", $this->entryLink->href);
        $this->assertEquals("via", $this->entryLink->rel);
        $this->assertTrue($this->entryLink->readOnly);
        $this->assertTrue($this->entryLink->entry instanceof \ZendGData\App\Entry);
        $this->assertEquals("Jo March", $this->entryLink->entry->title->text);
    }

}
