<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\GApps;

use ZendGData\GApps\Extension;

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class EmailListTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->emailListText = file_get_contents(
                'ZendGData/GApps/_files/EmailListElementSample1.xml',
                true);
        $this->emailList = new Extension\EmailList();
    }

    public function testEmptyEmailListShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->emailList->extensionElements));
        $this->assertTrue(count($this->emailList->extensionElements) == 0);
    }

    public function testEmptyEmailListShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->emailList->extensionAttributes));
        $this->assertTrue(count($this->emailList->extensionAttributes) == 0);
    }

    public function testSampleEmailListShouldHaveNoExtensionElements()
    {
        $this->emailList->transferFromXML($this->emailListText);
        $this->assertTrue(is_array($this->emailList->extensionElements));
        $this->assertTrue(count($this->emailList->extensionElements) == 0);
    }

    public function testSampleEmailListShouldHaveNoExtensionAttributes()
    {
        $this->emailList->transferFromXML($this->emailListText);
        $this->assertTrue(is_array($this->emailList->extensionAttributes));
        $this->assertTrue(count($this->emailList->extensionAttributes) == 0);
    }

    public function testNormalEmailListShouldHaveNoExtensionElements()
    {
        $this->emailList->name = "test-name";

        $this->assertEquals("test-name", $this->emailList->name);

        $this->assertEquals(0, count($this->emailList->extensionElements));
        $newEmailList = new Extension\EmailList();
        $newEmailList->transferFromXML($this->emailList->saveXML());
        $this->assertEquals(0, count($newEmailList->extensionElements));
        $newEmailList->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(1, count($newEmailList->extensionElements));
        $this->assertEquals("test-name", $newEmailList->name);

        /* try constructing using magic factory */
        $gdata = new \ZendGData\GApps();
        $newEmailList2 = $gdata->newEmailList();
        $newEmailList2->transferFromXML($newEmailList->saveXML());
        $this->assertEquals(1, count($newEmailList2->extensionElements));
        $this->assertEquals("test-name", $newEmailList2->name);
    }

    public function testEmptyEmailListToAndFromStringShouldMatch()
    {
        $emailListXml = $this->emailList->saveXML();
        $newEmailList = new Extension\EmailList();
        $newEmailList->transferFromXML($emailListXml);
        $newEmailListXml = $newEmailList->saveXML();
        $this->assertTrue($emailListXml == $newEmailListXml);
    }

    public function testEmailListWithValueToAndFromStringShouldMatch()
    {
        $this->emailList->name = "test-name";
        $emailListXml = $this->emailList->saveXML();
        $newEmailList = new Extension\EmailList();
        $newEmailList->transferFromXML($emailListXml);
        $newEmailListXml = $newEmailList->saveXML();
        $this->assertTrue($emailListXml == $newEmailListXml);
        $this->assertEquals("test-name", $this->emailList->name);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->emailList->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->emailList->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->emailList->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->emailList->extensionAttributes['foo2']['value']);
        $emailListXml = $this->emailList->saveXML();
        $newEmailList = new Extension\EmailList();
        $newEmailList->transferFromXML($emailListXml);
        $this->assertEquals('bar', $newEmailList->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newEmailList->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullEmailListToAndFromString()
    {
        $this->emailList->transferFromXML($this->emailListText);
        $this->assertEquals("us-sales", $this->emailList->name);
    }

}
