<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Calendar;

use ZendGData\Calendar\Extension;

/**
 * @category   Zend
 * @package    ZendGData\Calendar
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Calendar
 */
class TimezoneTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->timezoneText = file_get_contents(
                'ZendGData/Calendar/_files/TimezoneElementSample1.xml',
                true);
        $this->timezone = new Extension\Timezone();
    }

    public function testEmptyTimezoneShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->timezone->extensionElements));
        $this->assertTrue(count($this->timezone->extensionElements) == 0);
    }

    public function testEmptyTimezoneShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->timezone->extensionAttributes));
        $this->assertTrue(count($this->timezone->extensionAttributes) == 0);
    }

    public function testSampleTimezoneShouldHaveNoExtensionElements()
    {
        $this->timezone->transferFromXML($this->timezoneText);
        $this->assertTrue(is_array($this->timezone->extensionElements));
        $this->assertTrue(count($this->timezone->extensionElements) == 0);
    }

    public function testSampleTimezoneShouldHaveNoExtensionAttributes()
    {
        $this->timezone->transferFromXML($this->timezoneText);
        $this->assertTrue(is_array($this->timezone->extensionAttributes));
        $this->assertTrue(count($this->timezone->extensionAttributes) == 0);
    }

    public function testNormalTimezoneShouldHaveNoExtensionElements()
    {
        $this->timezone->value = "America/Chicago";
        $this->assertEquals($this->timezone->value, "America/Chicago");
        $this->assertEquals(count($this->timezone->extensionElements), 0);
        $newTimezone = new Extension\Timezone();
        $newTimezone->transferFromXML($this->timezone->saveXML());
        $this->assertEquals(count($newTimezone->extensionElements), 0);
        $newTimezone->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(count($newTimezone->extensionElements), 1);
        $this->assertEquals($newTimezone->value, "America/Chicago");

        /* try constructing using magic factory */
        $cal = new \ZendGData\Calendar();
        $newTimezone2 = $cal->newTimezone();
        $newTimezone2->transferFromXML($newTimezone->saveXML());
        $this->assertEquals(count($newTimezone2->extensionElements), 1);
        $this->assertEquals($newTimezone2->value, "America/Chicago");
    }

    public function testEmptyTimezoneToAndFromStringShouldMatch()
    {
        $timezoneXml = $this->timezone->saveXML();
        $newTimezone = new Extension\Timezone();
        $newTimezone->transferFromXML($timezoneXml);
        $newTimezoneXml = $newTimezone->saveXML();
        $this->assertTrue($timezoneXml == $newTimezoneXml);
    }

    public function testTimezoneWithValueToAndFromStringShouldMatch()
    {
        $this->timezone->value = "America/Chicago";
        $timezoneXml = $this->timezone->saveXML();
        $newTimezone = new Extension\Timezone();
        $newTimezone->transferFromXML($timezoneXml);
        $newTimezoneXml = $newTimezone->saveXML();
        $this->assertTrue($timezoneXml == $newTimezoneXml);
        $this->assertEquals("America/Chicago", $newTimezone->value);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->timezone->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->timezone->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->timezone->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->timezone->extensionAttributes['foo2']['value']);
        $timezoneXml = $this->timezone->saveXML();
        $newTimezone = new Extension\Timezone();
        $newTimezone->transferFromXML($timezoneXml);
        $this->assertEquals('bar', $newTimezone->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newTimezone->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullTimezoneToAndFromString()
    {
        $this->timezone->transferFromXML($this->timezoneText);
        $this->assertEquals($this->timezone->value, "America/Los_Angeles");
    }

}
