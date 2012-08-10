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
class SendEventNotificationsTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->sendEventNotificationsText = file_get_contents(
                'ZendGData/Calendar/_files/SendEventNotificationsElementSample1.xml',
                true);
        $this->sendEventNotifications = new Extension\SendEventNotifications();
    }

    public function testEmptySendEventNotificationsShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->sendEventNotifications->extensionElements));
        $this->assertTrue(count($this->sendEventNotifications->extensionElements) == 0);
    }

    public function testEmptySendEventNotificationsShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->sendEventNotifications->extensionAttributes));
        $this->assertTrue(count($this->sendEventNotifications->extensionAttributes) == 0);
    }

    public function testSampleSendEventNotificationsShouldHaveNoExtensionElements()
    {
        $this->sendEventNotifications->transferFromXML($this->sendEventNotificationsText);
        $this->assertTrue(is_array($this->sendEventNotifications->extensionElements));
        $this->assertTrue(count($this->sendEventNotifications->extensionElements) == 0);
    }

    public function testSampleSendEventNotificationsShouldHaveNoExtensionAttributes()
    {
        $this->sendEventNotifications->transferFromXML($this->sendEventNotificationsText);
        $this->assertTrue(is_array($this->sendEventNotifications->extensionAttributes));
        $this->assertTrue(count($this->sendEventNotifications->extensionAttributes) == 0);
    }

    public function testNormalSendEventNotificationsShouldHaveNoExtensionElements()
    {
        $this->sendEventNotifications->value = true;
        $this->assertEquals($this->sendEventNotifications->value, true);
        $this->assertEquals(count($this->sendEventNotifications->extensionElements), 0);
        $newSendEventNotifications = new Extension\SendEventNotifications();
        $newSendEventNotifications->transferFromXML($this->sendEventNotifications->saveXML());
        $this->assertEquals(count($newSendEventNotifications->extensionElements), 0);
        $newSendEventNotifications->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(count($newSendEventNotifications->extensionElements), 1);
        $this->assertEquals($newSendEventNotifications->value, true);

        /* try constructing using magic factory */
        $cal = new \ZendGData\Calendar();
        $newSendEventNotifications2 = $cal->newSendEventNotifications();
        $newSendEventNotifications2->transferFromXML($newSendEventNotifications->saveXML());
        $this->assertEquals(count($newSendEventNotifications2->extensionElements), 1);
        $this->assertEquals($newSendEventNotifications2->value, true);
    }

    public function testEmptySendEventNotificationsToAndFromStringShouldMatch()
    {
        $sendEventNotificationsXml = $this->sendEventNotifications->saveXML();
        $newSendEventNotifications = new Extension\SendEventNotifications();
        $newSendEventNotifications->transferFromXML($sendEventNotificationsXml);
        $newSendEventNotificationsXml = $newSendEventNotifications->saveXML();
        $this->assertTrue($sendEventNotificationsXml == $newSendEventNotificationsXml);
    }

    public function testSendEventNotificationsWithValueToAndFromStringShouldMatch()
    {
        $this->sendEventNotifications->value = true;
        $sendEventNotificationsXml = $this->sendEventNotifications->saveXML();
        $newSendEventNotifications = new Extension\SendEventNotifications();
        $newSendEventNotifications->transferFromXML($sendEventNotificationsXml);
        $newSendEventNotificationsXml = $newSendEventNotifications->saveXML();
        $this->assertTrue($sendEventNotificationsXml == $newSendEventNotificationsXml);
        $this->assertEquals(true, $newSendEventNotifications->value);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->sendEventNotifications->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->sendEventNotifications->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->sendEventNotifications->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->sendEventNotifications->extensionAttributes['foo2']['value']);
        $sendEventNotificationsXml = $this->sendEventNotifications->saveXML();
        $newSendEventNotifications = new Extension\SendEventNotifications();
        $newSendEventNotifications->transferFromXML($sendEventNotificationsXml);
        $this->assertEquals('bar', $newSendEventNotifications->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newSendEventNotifications->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullSendEventNotificationsToAndFromString()
    {
        $this->sendEventNotifications->transferFromXML($this->sendEventNotificationsText);
        $this->assertEquals($this->sendEventNotifications->value, false);
    }

}
