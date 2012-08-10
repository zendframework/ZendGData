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
class AccessLevelTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->accessLevelText = file_get_contents(
                'ZendGData/Calendar/_files/AccessLevelElementSample1.xml',
                true);
        $this->accessLevel = new Extension\AccessLevel();
    }

    public function testEmptyAccessLevelShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->accessLevel->extensionElements));
        $this->assertTrue(count($this->accessLevel->extensionElements) == 0);
    }

    public function testEmptyAccessLevelShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->accessLevel->extensionAttributes));
        $this->assertTrue(count($this->accessLevel->extensionAttributes) == 0);
    }

    public function testSampleAccessLevelShouldHaveNoExtensionElements()
    {
        $this->accessLevel->transferFromXML($this->accessLevelText);
        $this->assertTrue(is_array($this->accessLevel->extensionElements));
        $this->assertTrue(count($this->accessLevel->extensionElements) == 0);
    }

    public function testSampleAccessLevelShouldHaveNoExtensionAttributes()
    {
        $this->accessLevel->transferFromXML($this->accessLevelText);
        $this->assertTrue(is_array($this->accessLevel->extensionAttributes));
        $this->assertTrue(count($this->accessLevel->extensionAttributes) == 0);
    }

    public function testNormalAccessLevelShouldHaveNoExtensionElements()
    {
        $this->accessLevel->value = 'freebusy';
        $this->assertEquals($this->accessLevel->value, 'freebusy');
        $this->assertEquals(count($this->accessLevel->extensionElements), 0);
        $newAccessLevel = new Extension\AccessLevel();
        $newAccessLevel->transferFromXML($this->accessLevel->saveXML());
        $this->assertEquals(count($newAccessLevel->extensionElements), 0);
        $newAccessLevel->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(count($newAccessLevel->extensionElements), 1);
        $this->assertEquals($newAccessLevel->value, 'freebusy');

        /* try constructing using magic factory */
        $cal = new \ZendGData\Calendar();
        $newAccessLevel2 = $cal->newAccessLevel();
        $newAccessLevel2->transferFromXML($newAccessLevel->saveXML());
        $this->assertEquals(count($newAccessLevel2->extensionElements), 1);
        $this->assertEquals($newAccessLevel2->value, 'freebusy');
    }

    public function testEmptyAccessLevelToAndFromStringShouldMatch()
    {
        $accessLevelXml = $this->accessLevel->saveXML();
        $newAccessLevel = new Extension\AccessLevel();
        $newAccessLevel->transferFromXML($accessLevelXml);
        $newAccessLevelXml = $newAccessLevel->saveXML();
        $this->assertTrue($accessLevelXml == $newAccessLevelXml);
    }

    public function testAccessLevelWithValueToAndFromStringShouldMatch()
    {
        $this->accessLevel->value = 'freebusy';
        $accessLevelXml = $this->accessLevel->saveXML();
        $newAccessLevel = new Extension\AccessLevel();
        $newAccessLevel->transferFromXML($accessLevelXml);
        $newAccessLevelXml = $newAccessLevel->saveXML();
        $this->assertTrue($accessLevelXml == $newAccessLevelXml);
        $this->assertEquals('freebusy', $newAccessLevel->value);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->accessLevel->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->accessLevel->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->accessLevel->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->accessLevel->extensionAttributes['foo2']['value']);
        $accessLevelXml = $this->accessLevel->saveXML();
        $newAccessLevel = new Extension\AccessLevel();
        $newAccessLevel->transferFromXML($accessLevelXml);
        $this->assertEquals('bar', $newAccessLevel->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newAccessLevel->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullAccessLevelToAndFromString()
    {
        $this->accessLevel->transferFromXML($this->accessLevelText);
        $this->assertEquals($this->accessLevel->value, 'owner');
    }

}
