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
class OpenSearchTotalResultsTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->openSearchTotalResultsText = file_get_contents(
                'ZendGData/_files/OpenSearchTotalResultsElementSample1.xml',
                true);
        $this->openSearchTotalResults = new Extension\OpenSearchTotalResults();
    }

    public function testEmptyOpenSearchTotalResultsShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->openSearchTotalResults->extensionElements));
        $this->assertTrue(count($this->openSearchTotalResults->extensionElements) == 0);
    }

    public function testEmptyOpenSearchTotalResultsShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->openSearchTotalResults->extensionAttributes));
        $this->assertTrue(count($this->openSearchTotalResults->extensionAttributes) == 0);
    }

    public function testSampleOpenSearchTotalResultsShouldHaveNoExtensionElements()
    {
        $this->openSearchTotalResults->transferFromXML($this->openSearchTotalResultsText);
        $this->assertTrue(is_array($this->openSearchTotalResults->extensionElements));
        $this->assertTrue(count($this->openSearchTotalResults->extensionElements) == 0);
    }

    public function testSampleOpenSearchTotalResultsShouldHaveNoExtensionAttributes()
    {
        $this->openSearchTotalResults->transferFromXML($this->openSearchTotalResultsText);
        $this->assertTrue(is_array($this->openSearchTotalResults->extensionAttributes));
        $this->assertTrue(count($this->openSearchTotalResults->extensionAttributes) == 0);
    }

    public function testNormalOpenSearchTotalResultsShouldHaveNoExtensionElements()
    {
        $this->openSearchTotalResults->text = "42";

        $this->assertEquals("42", $this->openSearchTotalResults->text);

        $this->assertEquals(0, count($this->openSearchTotalResults->extensionElements));
        $newOpenSearchTotalResults = new Extension\OpenSearchTotalResults();
        $newOpenSearchTotalResults->transferFromXML($this->openSearchTotalResults->saveXML());
        $this->assertEquals(0, count($newOpenSearchTotalResults->extensionElements));
        $newOpenSearchTotalResults->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(1, count($newOpenSearchTotalResults->extensionElements));
        $this->assertEquals("42", $newOpenSearchTotalResults->text);

        /* try constructing using magic factory */
        $gdata = new \ZendGData\GData();
        $newOpenSearchTotalResults2 = $gdata->newOpenSearchTotalResults();
        $newOpenSearchTotalResults2->transferFromXML($newOpenSearchTotalResults->saveXML());
        $this->assertEquals(1, count($newOpenSearchTotalResults2->extensionElements));
        $this->assertEquals("42", $newOpenSearchTotalResults2->text);
    }

    public function testEmptyOpenSearchTotalResultsToAndFromStringShouldMatch()
    {
        $openSearchTotalResultsXml = $this->openSearchTotalResults->saveXML();
        $newOpenSearchTotalResults = new Extension\OpenSearchTotalResults();
        $newOpenSearchTotalResults->transferFromXML($openSearchTotalResultsXml);
        $newOpenSearchTotalResultsXml = $newOpenSearchTotalResults->saveXML();
        $this->assertTrue($openSearchTotalResultsXml == $newOpenSearchTotalResultsXml);
    }

    public function testOpenSearchTotalResultsWithValueToAndFromStringShouldMatch()
    {
        $this->openSearchTotalResults->text = "42";
        $openSearchTotalResultsXml = $this->openSearchTotalResults->saveXML();
        $newOpenSearchTotalResults = new Extension\OpenSearchTotalResults();
        $newOpenSearchTotalResults->transferFromXML($openSearchTotalResultsXml);
        $newOpenSearchTotalResultsXml = $newOpenSearchTotalResults->saveXML();
        $this->assertTrue($openSearchTotalResultsXml == $newOpenSearchTotalResultsXml);
        $this->assertEquals("42", $this->openSearchTotalResults->text);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->openSearchTotalResults->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->openSearchTotalResults->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->openSearchTotalResults->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->openSearchTotalResults->extensionAttributes['foo2']['value']);
        $openSearchTotalResultsXml = $this->openSearchTotalResults->saveXML();
        $newOpenSearchTotalResults = new Extension\OpenSearchTotalResults();
        $newOpenSearchTotalResults->transferFromXML($openSearchTotalResultsXml);
        $this->assertEquals('bar', $newOpenSearchTotalResults->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newOpenSearchTotalResults->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullOpenSearchTotalResultsToAndFromString()
    {
        $this->openSearchTotalResults->transferFromXML($this->openSearchTotalResultsText);
        $this->assertEquals("12", $this->openSearchTotalResults->text);
    }

}
