<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\App;

use ZendGData\App\Extension;

/**
 * @category   Zend
 * @package    ZendGData\App
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\App
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->categoryText = file_get_contents(
                'ZendGData/App/_files/CategoryElementSample1.xml',
                true);
        $this->category = new Extension\Category();
    }

    public function testEmptyCategoryShouldHaveEmptyExtensionsList()
    {
        $this->assertTrue(is_array($this->category->extensionElements));
        $this->assertTrue(count($this->category->extensionElements) == 0);
    }

    public function testNormalCategoryShouldHaveNoExtensionElements()
    {
        $this->category->scheme = 'http://schemas.google.com/g/2005#kind';
        $this->assertEquals($this->category->scheme, 'http://schemas.google.com/g/2005#kind');
        $this->assertEquals(count($this->category->extensionElements), 0);
        $newCategory = new Extension\Category();
        $newCategory->transferFromXML($this->category->saveXML());
        $this->assertEquals(0, count($newCategory->extensionElements));
        $newCategory->extensionElements = array(
                new Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(count($newCategory->extensionElements), 1);
        $this->assertEquals($newCategory->scheme, 'http://schemas.google.com/g/2005#kind');

        /* try constructing using magic factory */
        $app = new \ZendGData\App();
        $newCategory2 = $app->newCategory();
        $newCategory2->transferFromXML($newCategory->saveXML());
        $this->assertEquals(count($newCategory2->extensionElements), 1);
        $this->assertEquals($newCategory2->scheme, 'http://schemas.google.com/g/2005#kind');
    }

    public function testEmptyCategoryToAndFromStringShouldMatch()
    {
        $categoryXml = $this->category->saveXML();
        $newCategory = new Extension\Category();
        $newCategory->transferFromXML($categoryXml);
        $newCategoryXml = $newCategory->saveXML();
        $this->assertTrue($categoryXml == $newCategoryXml);
    }

    public function testCategoryWithSchemeAndTermToAndFromStringShouldMatch()
    {
        $this->category->scheme = 'http://schemas.google.com/g/2005#kind';
        $this->category->term = 'http://schemas.google.com/g/2005#event';
        $this->category->label = 'event kind';
        $categoryXml = $this->category->saveXML();
        $newCategory = new Extension\Category();
        $newCategory->transferFromXML($categoryXml);
        $newCategoryXml = $newCategory->saveXML();
        $this->assertTrue($categoryXml == $newCategoryXml);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $newCategory->scheme);
        $this->assertEquals('http://schemas.google.com/g/2005#event', $newCategory->term);
        $this->assertEquals('event kind', $newCategory->label);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->category->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->category->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->category->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->category->extensionAttributes['foo2']['value']);
        $categoryXml = $this->category->saveXML();
        $newCategory = new Extension\Category();
        $newCategory->transferFromXML($categoryXml);
        $this->assertEquals('bar', $newCategory->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newCategory->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullCategoryToAndFromString()
    {
        $this->category->transferFromXML($this->categoryText);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $this->category->scheme);
        $this->assertEquals('http://schemas.google.com/g/2005#event', $this->category->term);
        $this->assertEquals('event kind', $this->category->label);
    }

}
