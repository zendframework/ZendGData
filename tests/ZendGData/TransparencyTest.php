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
class TransparencyTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->transparencyText = file_get_contents(
                'ZendGData/_files/TransparencyElementSample1.xml',
                true);
        $this->transparency = new Extension\Transparency();
    }

    public function testEmptyTransparencyShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->transparency->extensionElements));
        $this->assertTrue(count($this->transparency->extensionElements) == 0);
    }

    public function testEmptyTransparencyShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->transparency->extensionAttributes));
        $this->assertTrue(count($this->transparency->extensionAttributes) == 0);
    }

    public function testSampleTransparencyShouldHaveNoExtensionElements()
    {
        $this->transparency->transferFromXML($this->transparencyText);
        $this->assertTrue(is_array($this->transparency->extensionElements));
        $this->assertTrue(count($this->transparency->extensionElements) == 0);
    }

    public function testSampleTransparencyShouldHaveNoExtensionAttributes()
    {
        $this->transparency->transferFromXML($this->transparencyText);
        $this->assertTrue(is_array($this->transparency->extensionAttributes));
        $this->assertTrue(count($this->transparency->extensionAttributes) == 0);
    }

    public function testNormalTransparencyShouldHaveNoExtensionElements()
    {
        $this->transparency->value = "http://schemas.google.com/g/2005#event.opaque";

        $this->assertEquals("http://schemas.google.com/g/2005#event.opaque", $this->transparency->value);

        $this->assertEquals(0, count($this->transparency->extensionElements));
        $newTransparency = new Extension\Transparency();
        $newTransparency->transferFromXML($this->transparency->saveXML());
        $this->assertEquals(0, count($newTransparency->extensionElements));
        $newTransparency->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(1, count($newTransparency->extensionElements));
        $this->assertEquals("http://schemas.google.com/g/2005#event.opaque", $newTransparency->value);

        /* try constructing using magic factory */
        $gdata = new \ZendGData\GData();
        $newTransparency2 = $gdata->newTransparency();
        $newTransparency2->transferFromXML($newTransparency->saveXML());
        $this->assertEquals(1, count($newTransparency2->extensionElements));
        $this->assertEquals("http://schemas.google.com/g/2005#event.opaque", $newTransparency2->value);
    }

    public function testEmptyTransparencyToAndFromStringShouldMatch()
    {
        $transparencyXml = $this->transparency->saveXML();
        $newTransparency = new Extension\Transparency();
        $newTransparency->transferFromXML($transparencyXml);
        $newTransparencyXml = $newTransparency->saveXML();
        $this->assertTrue($transparencyXml == $newTransparencyXml);
    }

    public function testTransparencyWithValueToAndFromStringShouldMatch()
    {
        $this->transparency->value = "http://schemas.google.com/g/2005#event.opaque";
        $transparencyXml = $this->transparency->saveXML();
        $newTransparency = new Extension\Transparency();
        $newTransparency->transferFromXML($transparencyXml);
        $newTransparencyXml = $newTransparency->saveXML();
        $this->assertTrue($transparencyXml == $newTransparencyXml);
        $this->assertEquals("http://schemas.google.com/g/2005#event.opaque", $this->transparency->value);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->transparency->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->transparency->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->transparency->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->transparency->extensionAttributes['foo2']['value']);
        $transparencyXml = $this->transparency->saveXML();
        $newTransparency = new Extension\Transparency();
        $newTransparency->transferFromXML($transparencyXml);
        $this->assertEquals('bar', $newTransparency->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newTransparency->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullTransparencyToAndFromString()
    {
        $this->transparency->transferFromXML($this->transparencyText);
        $this->assertEquals("http://schemas.google.com/g/2005#event.transparent", $this->transparency->value);
    }

}
