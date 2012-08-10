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
class RecurrenceTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->recurrenceText = file_get_contents(
                'ZendGData/_files/RecurrenceElementSample1.xml',
                true);
        $this->recurrence = new Extension\Recurrence();
    }

    public function testEmptyRecurrenceShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->recurrence->extensionElements));
        $this->assertTrue(count($this->recurrence->extensionElements) == 0);
    }

    public function testEmptyRecurrenceShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->recurrence->extensionAttributes));
        $this->assertTrue(count($this->recurrence->extensionAttributes) == 0);
    }

    public function testSampleRecurrenceShouldHaveNoExtensionElements()
    {
        $this->recurrence->transferFromXML($this->recurrenceText);
        $this->assertTrue(is_array($this->recurrence->extensionElements));
        $this->assertTrue(count($this->recurrence->extensionElements) == 0);
    }

    public function testSampleRecurrenceShouldHaveNoExtensionAttributes()
    {
        $this->recurrence->transferFromXML($this->recurrenceText);
        $this->assertTrue(is_array($this->recurrence->extensionAttributes));
        $this->assertTrue(count($this->recurrence->extensionAttributes) == 0);
    }

    public function testNormalRecurrenceShouldHaveNoExtensionElements()
    {
        $this->recurrence->text = "Foo";

        $this->assertEquals("Foo", $this->recurrence->text);

        $this->assertEquals(0, count($this->recurrence->extensionElements));
        $newRecurrence = new Extension\Recurrence();
        $newRecurrence->transferFromXML($this->recurrence->saveXML());
        $this->assertEquals(0, count($newRecurrence->extensionElements));
        $newRecurrence->extensionElements = array(
                new \ZendGData\App\Extension\Element('foo', 'atom', null, 'bar'));
        $this->assertEquals(1, count($newRecurrence->extensionElements));
        $this->assertEquals("Foo", $newRecurrence->text);

        /* try constructing using magic factory */
        $gdata = new \ZendGData\GData();
        $newRecurrence2 = $gdata->newRecurrence();
        $newRecurrence2->transferFromXML($newRecurrence->saveXML());
        $this->assertEquals(1, count($newRecurrence2->extensionElements));
        $this->assertEquals("Foo", $newRecurrence2->text);
    }

    public function testEmptyRecurrenceToAndFromStringShouldMatch()
    {
        $recurrenceXml = $this->recurrence->saveXML();
        $newRecurrence = new Extension\Recurrence();
        $newRecurrence->transferFromXML($recurrenceXml);
        $newRecurrenceXml = $newRecurrence->saveXML();
        $this->assertTrue($recurrenceXml == $newRecurrenceXml);
    }

    public function testRecurrenceWithValueToAndFromStringShouldMatch()
    {
        $this->recurrence->text = "Foo";
        $recurrenceXml = $this->recurrence->saveXML();
        $newRecurrence = new Extension\Recurrence();
        $newRecurrence->transferFromXML($recurrenceXml);
        $newRecurrenceXml = $newRecurrence->saveXML();
        $this->assertTrue($recurrenceXml == $newRecurrenceXml);
        $this->assertEquals("Foo", $this->recurrence->text);
    }

    public function testExtensionAttributes()
    {
        $extensionAttributes = $this->recurrence->extensionAttributes;
        $extensionAttributes['foo1'] = array('name'=>'foo1', 'value'=>'bar');
        $extensionAttributes['foo2'] = array('name'=>'foo2', 'value'=>'rab');
        $this->recurrence->extensionAttributes = $extensionAttributes;
        $this->assertEquals('bar', $this->recurrence->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $this->recurrence->extensionAttributes['foo2']['value']);
        $recurrenceXml = $this->recurrence->saveXML();
        $newRecurrence = new Extension\Recurrence();
        $newRecurrence->transferFromXML($recurrenceXml);
        $this->assertEquals('bar', $newRecurrence->extensionAttributes['foo1']['value']);
        $this->assertEquals('rab', $newRecurrence->extensionAttributes['foo2']['value']);
    }

    public function testConvertFullRecurrenceToAndFromString()
    {
        $this->recurrence->transferFromXML($this->recurrenceText);
        $this->assertEquals("DTSTART;VALUE=DATE:20070501\nDTEND;VALUE=DATE:20070502\nRRULE:FREQ=WEEKLY;BYDAY=Tu;UNTIL=20070904", $this->recurrence->text);
    }

}
