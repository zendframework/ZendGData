<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Photos;

/**
 * @category   Zend
 * @package    ZendGData\Photos
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Photos
 */
class PhotosTagEntryTest extends \PHPUnit_Framework_TestCase
{

    protected $tagEntry = null;

    /**
      * Called before each test to setup any fixtures.
      */
    public function setUp()
    {
        $tagEntryText = file_get_contents(
                '_files/TestTagEntry.xml',
                true);
        $this->tagEntry = new \ZendGData\Photos\TagEntry($tagEntryText);
    }

    /**
      * Verify that a given property is set to a specific value
      * and that the getter and magic variable return the same value.
      *
      * @param object $obj The object to be interrogated.
      * @param string $name The name of the property to be verified.
      * @param object $value The expected value of the property.
      */
    protected function verifyProperty($obj, $name, $value)
    {
        $propName = $name;
        $propGetter = "get" . ucfirst($name);

        $this->assertEquals($obj->$propGetter(), $obj->$propName);
        $this->assertEquals($value, $obj->$propGetter());
    }

    /**
      * Verify that a given property is set to a specific value
      * and that the getter and magic variable return the same value.
      *
      * @param object $obj The object to be interrogated.
      * @param string $name The name of the property to be verified.
      * @param string $secondName 2nd level accessor function name
      * @param object $value The expected value of the property.
      */
    protected function verifyProperty2($obj, $name, $secondName, $value)
    {
        $propName = $name;
        $propGetter = "get" . ucfirst($name);
        $secondGetter = "get" . ucfirst($secondName);

        $this->assertEquals($obj->$propGetter(), $obj->$propName);
        $this->assertEquals($value, $obj->$propGetter()->$secondGetter());
    }

    /**
      * Check for the existence of an <atom:id> and verify that it contains
      * the expected value.
      */
    public function testId()
    {
        $entry = $this->tagEntry;

        // Assert that the entry's ID is correct
        $this->assertTrue($entry->getId() instanceof \ZendGData\App\Extension\Id);
        $this->verifyProperty2($entry, "id", "text",
                "http://picasaweb.google.com/data/entry/api/user/sample.user/tag/tag");
    }

    /**
      * Check for the existence of an <atom:updated> and verify that it contains
      * the expected value.
      */
    public function testUpdated()
    {
        $entry = $this->tagEntry;

        // Assert that the entry's updated date is correct
        $this->assertTrue($entry->getUpdated() instanceof \ZendGData\App\Extension\Updated);
        $this->verifyProperty2($entry, "updated", "text",
                "1970-01-01T00:01:01.000Z");
    }

    /**
      * Check for the existence of an <atom:title> and verify that it contains
      * the expected value.
      */
    public function testTitle()
    {
        $entry = $this->tagEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getTitle() instanceof \ZendGData\App\Extension\Title);
        $this->verifyProperty2($entry, "title", "text", "tag");
    }

}
