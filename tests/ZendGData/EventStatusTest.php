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
class EventStatusTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->eventStatusText = file_get_contents(
                'ZendGData/_files/EventStatusElementSample1.xml',
                true);
        $this->eventStatus = new Extension\EventStatus();
    }

    public function testEmptyEventStatusShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->eventStatus->extensionElements));
        $this->assertTrue(count($this->eventStatus->extensionElements) == 0);
    }

    public function testEmptyEventStatusShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->eventStatus->extensionAttributes));
        $this->assertTrue(count($this->eventStatus->extensionAttributes) == 0);
    }

    public function testSampleEventStatusShouldHaveNoExtensionElements()
    {
        $this->eventStatus->transferFromXML($this->eventStatusText);
        $this->assertTrue(is_array($this->eventStatus->extensionElements));
        $this->assertTrue(count($this->eventStatus->extensionElements) == 0);
    }

    public function testSampleEventStatusShouldHaveNoExtensionAttributes()
    {
        $this->eventStatus->transferFromXML($this->eventStatusText);
        $this->assertTrue(is_array($this->eventStatus->extensionAttributes));
        $this->assertTrue(count($this->eventStatus->extensionAttributes) == 0);
    }

    public function testNormalEventStatusShouldHaveNoExtensionElements()
    {
        $this->eventStatus->value = "http://schemas.google.com/g/2005#event.tentative";

        $this->assertEquals("http://schemas.google.com/g/2005#event.tentative", $this->eventStatus->value);

        $this->assertEquals(0, count($this->eventStatus->extensionElements));
        $newEventStatus = new Extension\EventStatus();
        $newEventStatus->transferFromXML($this->eventStatus->saveXML());
        $this->assertEquals(0, count($newEventStatus->extensionElements));
        $newEventStatus->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(1, count($newEventStatus->extensionElements));
        $this->assertEquals("http://schemas.google.com/g/2005#event.tentative", $newEventStatus->value);

        /* try constructing using magic factory */
        $gdata = new \ZendGData\GData();
        $newEventStatus2 = $gdata->newEventStatus();
        $newEventStatus2->transferFromXML($newEventStatus->saveXML());
        $this->assertEquals(1, count($newEventStatus2->extensionElements));
        $this->assertEquals("http://schemas.google.com/g/2005#event.tentative", $newEventStatus2->value);
    }

    public function testEmptyEventStatusToAndFromStringShouldMatch()
    {
        $eventStatusXml = $this->eventStatus->saveXML();
        $newEventStatus = new Extension\EventStatus();
        $newEventStatus->transferFromXML($eventStatusXml);
        $newEventStatusXml = $newEventStatus->saveXML();
        $this->assertTrue($eventStatusXml == $newEventStatusXml);
    }

    public function testEventStatusWithValueToAndFromStringShouldMatch()
    {
        $this->eventStatus->value = "http://schemas.google.com/g/2005#event.tentative";
        $eventStatusXml = $this->eventStatus->saveXML();
        $newEventStatus = new Extension\EventStatus();
        $newEventStatus->transferFromXML($eventStatusXml);
        $newEventStatusXml = $newEventStatus->saveXML();
        $this->assertTrue($eventStatusXml == $newEventStatusXml);
        $this->assertEquals("http://schemas.google.com/g/2005#event.tentative", $this->eventStatus->value);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->eventStatus->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->eventStatus->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->eventStatus->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->eventStatus->extensionAttributes['foo2']['value']);
        $eventStatusXml = $this->eventStatus->saveXML();
        $newEventStatus = new Extension\EventStatus();
        $newEventStatus->transferFromXML($eventStatusXml);
        $this->assertEquals('bar', $newEventStatus->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newEventStatus->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullEventStatusToAndFromString()
    {
        $this->eventStatus->transferFromXML($this->eventStatusText);
        $this->assertEquals("http://schemas.google.com/g/2005#event.confirmed", $this->eventStatus->value);
    }

}
