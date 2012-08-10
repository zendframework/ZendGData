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
class ColorTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->colorText = file_get_contents(
                'ZendGData/Calendar/_files/ColorElementSample1.xml',
                true);
        $this->color = new Extension\Color();
    }

    public function testEmptyColorShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->color->extensionElements));
        $this->assertTrue(count($this->color->extensionElements) == 0);
    }

    public function testEmptyColorShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->color->extensionAttributes));
        $this->assertTrue(count($this->color->extensionAttributes) == 0);
    }

    public function testSampleColorShouldHaveNoExtensionElements()
    {
        $this->color->transferFromXML($this->colorText);
        $this->assertTrue(is_array($this->color->extensionElements));
        $this->assertTrue(count($this->color->extensionElements) == 0);
    }

    public function testSampleColorShouldHaveNoExtensionAttributes()
    {
        $this->color->transferFromXML($this->colorText);
        $this->assertTrue(is_array($this->color->extensionAttributes));
        $this->assertTrue(count($this->color->extensionAttributes) == 0);
    }

    public function testNormalColorShouldHaveNoExtensionElements()
    {
        $this->color->value = '#abcdef';
        $this->assertEquals($this->color->value, '#abcdef');
        $this->assertEquals(count($this->color->extensionElements), 0);
        $newColor = new Extension\Color();
        $newColor->transferFromXML($this->color->saveXML());
        $this->assertEquals(count($newColor->extensionElements), 0);
        $newColor->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(count($newColor->extensionElements), 1);
        $this->assertEquals($newColor->value, '#abcdef');

        /* try constructing using magic factory */
        $cal = new \ZendGData\Calendar();
        $newColor2 = $cal->newColor();
        $newColor2->transferFromXML($newColor->saveXML());
        $this->assertEquals(count($newColor2->extensionElements), 1);
        $this->assertEquals($newColor2->value, '#abcdef');
    }

    public function testEmptyColorToAndFromStringShouldMatch()
    {
        $colorXml = $this->color->saveXML();
        $newColor = new Extension\Color();
        $newColor->transferFromXML($colorXml);
        $newColorXml = $newColor->saveXML();
        $this->assertTrue($colorXml == $newColorXml);
    }

    public function testColorWithValueToAndFromStringShouldMatch()
    {
        $this->color->value = '#abcdef';
        $colorXml = $this->color->saveXML();
        $newColor = new Extension\Color();
        $newColor->transferFromXML($colorXml);
        $newColorXml = $newColor->saveXML();
        $this->assertTrue($colorXml == $newColorXml);
        $this->assertEquals('#abcdef', $newColor->value);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->color->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->color->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->color->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->color->extensionAttributes['foo2']['value']);
        $colorXml = $this->color->saveXML();
        $newColor = new Extension\Color();
        $newColor->transferFromXML($colorXml);
        $this->assertEquals('bar', $newColor->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newColor->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullColorToAndFromString()
    {
        $this->color->transferFromXML($this->colorText);
        $this->assertEquals($this->color->value, '#5A6986');
    }

}
