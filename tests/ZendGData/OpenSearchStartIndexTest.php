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
 * @package    ZendGData\OpenSearch
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\OpenSearch
 */
class OpenSearchStartIndexTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->openSearchStartIndexText = file_get_contents(
                'ZendGData/_files/OpenSearchStartIndexElementSample1.xml',
                true);
        $this->openSearchStartIndex = new Extension\OpenSearchStartIndex();
    }

    public function testEmptyOpenSearchStartIndexShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->openSearchStartIndex->extensionElements));
        $this->assertTrue(count($this->openSearchStartIndex->extensionElements) == 0);
    }

    public function testEmptyOpenSearchStartIndexShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->openSearchStartIndex->extensionAttributes));
        $this->assertTrue(count($this->openSearchStartIndex->extensionAttributes) == 0);
    }

    public function testSampleOpenSearchStartIndexShouldHaveNoExtensionElements()
    {
        $this->openSearchStartIndex->transferFromXML($this->openSearchStartIndexText);
        $this->assertTrue(is_array($this->openSearchStartIndex->extensionElements));
        $this->assertTrue(count($this->openSearchStartIndex->extensionElements) == 0);
    }

    public function testSampleOpenSearchStartIndexShouldHaveNoExtensionAttributes()
    {
        $this->openSearchStartIndex->transferFromXML($this->openSearchStartIndexText);
        $this->assertTrue(is_array($this->openSearchStartIndex->extensionAttributes));
        $this->assertTrue(count($this->openSearchStartIndex->extensionAttributes) == 0);
    }

    public function testNormalOpenSearchStartIndexShouldHaveNoExtensionElements()
    {
        $this->openSearchStartIndex->text = "20";

        $this->assertEquals("20", $this->openSearchStartIndex->text);

        $this->assertEquals(0, count($this->openSearchStartIndex->extensionElements));
        $newOpenSearchStartIndex = new Extension\OpenSearchStartIndex();
        $newOpenSearchStartIndex->transferFromXML($this->openSearchStartIndex->saveXML());
        $this->assertEquals(0, count($newOpenSearchStartIndex->extensionElements));
        $newOpenSearchStartIndex->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(1, count($newOpenSearchStartIndex->extensionElements));
        $this->assertEquals("20", $newOpenSearchStartIndex->text);

        /* try constructing using magic factory */
        $gdata = new \ZendGData\GData();
        $newOpenSearchStartIndex2 = $gdata->newOpenSearchStartIndex();
        $newOpenSearchStartIndex2->transferFromXML($newOpenSearchStartIndex->saveXML());
        $this->assertEquals(1, count($newOpenSearchStartIndex2->extensionElements));
        $this->assertEquals("20", $newOpenSearchStartIndex2->text);
    }

    public function testEmptyOpenSearchStartIndexToAndFromStringShouldMatch()
    {
        $openSearchStartIndexXml = $this->openSearchStartIndex->saveXML();
        $newOpenSearchStartIndex = new Extension\OpenSearchStartIndex();
        $newOpenSearchStartIndex->transferFromXML($openSearchStartIndexXml);
        $newOpenSearchStartIndexXml = $newOpenSearchStartIndex->saveXML();
        $this->assertTrue($openSearchStartIndexXml == $newOpenSearchStartIndexXml);
    }

    public function testOpenSearchStartIndexWithValueToAndFromStringShouldMatch()
    {
        $this->openSearchStartIndex->text = "20";
        $openSearchStartIndexXml = $this->openSearchStartIndex->saveXML();
        $newOpenSearchStartIndex = new Extension\OpenSearchStartIndex();
        $newOpenSearchStartIndex->transferFromXML($openSearchStartIndexXml);
        $newOpenSearchStartIndexXml = $newOpenSearchStartIndex->saveXML();
        $this->assertTrue($openSearchStartIndexXml == $newOpenSearchStartIndexXml);
        $this->assertEquals("20", $this->openSearchStartIndex->text);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->openSearchStartIndex->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->openSearchStartIndex->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->openSearchStartIndex->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->openSearchStartIndex->extensionAttributes['foo2']['value']);
        $openSearchStartIndexXml = $this->openSearchStartIndex->saveXML();
        $newOpenSearchStartIndex = new Extension\OpenSearchStartIndex();
        $newOpenSearchStartIndex->transferFromXML($openSearchStartIndexXml);
        $this->assertEquals('bar', $newOpenSearchStartIndex->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newOpenSearchStartIndex->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullOpenSearchStartIndexToAndFromString()
    {
        $this->openSearchStartIndex->transferFromXML($this->openSearchStartIndexText);
        $this->assertEquals("5", $this->openSearchStartIndex->text);
    }

}
