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
class OriginalEventTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->originalEventText = file_get_contents(
                'ZendGData/_files/OriginalEventElementSample1.xml',
                true);
        $this->originalEvent = new Extension\OriginalEvent();
    }

    public function testEmptyOriginalEventShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->originalEvent->extensionElements));
        $this->assertTrue(count($this->originalEvent->extensionElements) == 0);
    }

    public function testEmptyOriginalEventShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->originalEvent->extensionAttributes));
        $this->assertTrue(count($this->originalEvent->extensionAttributes) == 0);
    }

    public function testSampleOriginalEventShouldHaveNoExtensionElements()
    {
        $this->originalEvent->transferFromXML($this->originalEventText);
        $this->assertTrue(is_array($this->originalEvent->extensionElements));
        $this->assertTrue(count($this->originalEvent->extensionElements) == 0);
    }

    public function testSampleOriginalEventShouldHaveNoExtensionAttributes()
    {
        $this->originalEvent->transferFromXML($this->originalEventText);
        $this->assertTrue(is_array($this->originalEvent->extensionAttributes));
        $this->assertTrue(count($this->originalEvent->extensionAttributes) == 0);
    }

    public function testNormalOriginalEventShouldHaveNoExtensionElements()
    {
        $this->originalEvent->href = "http://www.google.com/calendar/feeds/nobody@gmail.com/private/composite";
        $this->originalEvent->id = "abcdef123456789";

        $this->assertEquals("http://www.google.com/calendar/feeds/nobody@gmail.com/private/composite", $this->originalEvent->href);
        $this->assertEquals("abcdef123456789", $this->originalEvent->id);

        $this->assertEquals(0, count($this->originalEvent->extensionElements));
        $newOriginalEvent = new Extension\OriginalEvent();
        $newOriginalEvent->transferFromXML($this->originalEvent->saveXML());
        $this->assertEquals(0, count($newOriginalEvent->extensionElements));
        $newOriginalEvent->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(1, count($newOriginalEvent->extensionElements));
        $this->assertEquals("http://www.google.com/calendar/feeds/nobody@gmail.com/private/composite", $newOriginalEvent->href);
        $this->assertEquals("abcdef123456789", $newOriginalEvent->id);

        /* try constructing using magic factory */
        $gdata = new \ZendGData\GData();
        $newOriginalEvent2 = $gdata->newOriginalEvent();
        $newOriginalEvent2->transferFromXML($newOriginalEvent->saveXML());
        $this->assertEquals(1, count($newOriginalEvent2->extensionElements));
        $this->assertEquals("http://www.google.com/calendar/feeds/nobody@gmail.com/private/composite", $newOriginalEvent2->href);
        $this->assertEquals("abcdef123456789", $newOriginalEvent2->id);
    }

    public function testEmptyOriginalEventToAndFromStringShouldMatch()
    {
        $originalEventXml = $this->originalEvent->saveXML();
        $newOriginalEvent = new Extension\OriginalEvent();
        $newOriginalEvent->transferFromXML($originalEventXml);
        $newOriginalEventXml = $newOriginalEvent->saveXML();
        $this->assertTrue($originalEventXml == $newOriginalEventXml);
    }

    public function testOriginalEventWithValueToAndFromStringShouldMatch()
    {
        $this->originalEvent->href = "http://www.google.com/calendar/feeds/nobody@gmail.com/private/composite";
        $this->originalEvent->id = "abcdef123456789";
        $originalEventXml = $this->originalEvent->saveXML();
        $newOriginalEvent = new Extension\OriginalEvent();
        $newOriginalEvent->transferFromXML($originalEventXml);
        $newOriginalEventXml = $newOriginalEvent->saveXML();
        $this->assertTrue($originalEventXml == $newOriginalEventXml);
        $this->assertEquals("http://www.google.com/calendar/feeds/nobody@gmail.com/private/composite", $this->originalEvent->href);
        $this->assertEquals("abcdef123456789", $this->originalEvent->id);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->originalEvent->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->originalEvent->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->originalEvent->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->originalEvent->extensionAttributes['foo2']['value']);
        $originalEventXml = $this->originalEvent->saveXML();
        $newOriginalEvent = new Extension\OriginalEvent();
        $newOriginalEvent->transferFromXML($originalEventXml);
        $this->assertEquals('bar', $newOriginalEvent->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newOriginalEvent->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullOriginalEventToAndFromString()
    {
        $this->originalEvent->transferFromXML($this->originalEventText);
        $this->assertEquals("http://www.google.com/calendar/feeds/userID/private/full/123456789", $this->originalEvent->href);
        $this->assertEquals("i8fl1nrv2bl57c1qgr3f0onmgg", $this->originalEvent->id);
        $this->assertTrue($this->originalEvent->when instanceof Extension\When);
        $this->assertEquals("2006-03-17T22:00:00.000Z", $this->originalEvent->when->startTime);
    }

}
