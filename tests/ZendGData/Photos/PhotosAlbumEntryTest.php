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
class PhotosAlbumEntryTest extends \PHPUnit_Framework_TestCase
{

    protected $albumEntry = null;

    /**
      * Called before each test to setup any fixtures.
      */
    public function setUp()
    {
        $albumEntryText = file_get_contents(
                '_files/TestAlbumEntry.xml',
                true);
        $this->albumEntry = new \ZendGData\Photos\AlbumEntry($albumEntryText);
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
      * Verify that a given property is set to a specific value,
      * that it keeps that value when set using the setter,
      * and that the getter and magic variable return the same value.
      *
      * @param object $obj The object to be interrogated.
      * @param string $name The name of the property to be verified.
      * @param string $secondName 2nd level accessor function name
      * @param object $value The expected value of the property.
      */
    protected function verifyProperty3($obj, $name, $secondName, $value)
    {
        $propName = $name;
        $propGetter = "get" . ucfirst($name);
        $propSetter = "set" . ucfirst($name);
        $secondGetter = "get" . ucfirst($secondName);
        $secondSetter = "set" . ucfirst($secondName);

        $this->assertEquals($obj->$propGetter(), $obj->$propName);
        $obj->$propSetter($obj->$propName);
        $this->assertEquals($value, $obj->$propGetter()->$secondGetter());
    }

    /**
      * Check for the existence of an <atom:author> and verify that they
      * contain the expected values.
      */
    public function testAuthor()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's author is correct
        $entryAuthor = $entry->getAuthor();
        $this->assertEquals($entryAuthor, $entry->author);
        $this->assertEquals(1, count($entryAuthor));
        $this->assertTrue($entryAuthor[0] instanceof \ZendGData\App\Extension\Author);
        $this->verifyProperty2($entryAuthor[0], "name", "text", "sample");
        $this->assertTrue($entryAuthor[0]->getUri() instanceof \ZendGData\App\Extension\Uri);
        $this->verifyProperty2($entryAuthor[0], "uri", "text", "http://picasaweb.google.com/sample.user");
    }

    /**
      * Check for the existence of an <atom:id> and verify that it contains
      * the expected value.
      */
    public function testId()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's ID is correct
        $this->assertTrue($entry->getId() instanceof \ZendGData\App\Extension\Id);
        $this->verifyProperty2($entry, "id", "text",
                "http://picasaweb.google.com/data/entry/api/user/sample.user/albumid/1");
    }

    /**
      * Check for the existence of an <atom:published> and verify that it contains
      * the expected value.
      */
    public function testPublished()
    {
        $entry = $this->albumEntry;

        // Assert that the photo entry has an Atom Published object
        $this->assertTrue($entry->getPublished() instanceof \ZendGData\App\Extension\Published);
        $this->verifyProperty2($entry, "published", "text", "2007-09-05T07:00:00.000Z");
    }

    /**
      * Check for the existence of an <atom:updated> and verify that it contains
      * the expected value.
      */
    public function testUpdated()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's updated date is correct
        $this->assertTrue($entry->getUpdated() instanceof \ZendGData\App\Extension\Updated);
        $this->verifyProperty2($entry, "updated", "text",
                "2007-09-05T20:49:24.000Z");
    }

    /**
      * Check for the existence of an <atom:title> and verify that it contains
      * the expected value.
      */
    public function testTitle()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getTitle() instanceof \ZendGData\App\Extension\Title);
        $this->verifyProperty2($entry, "title", "text", "Test");
    }

    /**
      * Check for the existence of an <gphoto:user> and verify that it contains
      * the expected value.
      */
    public function testGphotoUser()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoUser() instanceof \ZendGData\Photos\Extension\User);
        $this->verifyProperty2($entry, "gphotoUser", "text",
                "sample.user");
        $this->verifyProperty3($entry, "gphotoUser", "text",
                "sample.user");
    }

    /**
      * Check for the existence of an <gphoto:nickname> and verify that it contains
      * the expected value.
      */
    public function testGphotoNickname()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoNickname() instanceof \ZendGData\Photos\Extension\Nickname);
        $this->verifyProperty2($entry, "gphotoNickname", "text",
                "sample");
        $this->verifyProperty3($entry, "gphotoNickname", "text",
                "sample");
    }

    /**
      * Check for the existence of an <gphoto:name> and verify that it contains
      * the expected value.
      */
    public function testGphotoName()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoName() instanceof \ZendGData\Photos\Extension\Name);
        $this->verifyProperty2($entry, "gphotoName", "text",
                "Test");
        $this->verifyProperty3($entry, "gphotoName", "text",
                "Test");
    }

    /**
      * Check for the existence of an <gphoto:id> and verify that it contains
      * the expected value.
      */
    public function testGphotoId()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoId() instanceof \ZendGData\Photos\Extension\Id);
        $this->verifyProperty2($entry, "gphotoId", "text",
                "1");
        $this->verifyProperty3($entry, "gphotoId", "text",
                "1");
    }

    /**
      * Check for the existence of an <gphoto:location> and verify that it contains
      * the expected value.
      */
    public function testGphotoLocation()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoLocation() instanceof \ZendGData\Photos\Extension\Location);
        $this->verifyProperty2($entry, "gphotoLocation", "text",
                "");
    }

    /**
      * Check for the existence of an <gphoto:access> and verify that it contains
      * the expected value.
      */
    public function testGphotoAccess()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoAccess() instanceof \ZendGData\Photos\Extension\Access);
        $this->verifyProperty2($entry, "gphotoAccess", "text",
                "public");
        $this->verifyProperty3($entry, "gphotoAccess", "text",
                "public");
    }

    /**
      * Check for the existence of an <gphoto:timestamp> and verify that it contains
      * the expected value.
      */
    public function testGphotoTimestamp()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoTimestamp() instanceof \ZendGData\Photos\Extension\Timestamp);
        $this->verifyProperty2($entry, "gphotoTimestamp", "text",
                "1188975600000");
        $this->verifyProperty3($entry, "gphotoTimestamp", "text",
                "1188975600000");
    }

    /**
      * Check for the existence of an <gphoto:numphotos> and verify that it contains
      * the expected value.
      */
    public function testGphotoNumPhotos()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoNumPhotos() instanceof \ZendGData\Photos\Extension\NumPhotos);
        $this->verifyProperty2($entry, "gphotoNumPhotos", "text",
                "2");
        $this->verifyProperty3($entry, "gphotoNumPhotos", "text",
                "2");
    }

    /**
      * Check for the existence of an <gphoto:commentingEnabled> and verify that it contains
      * the expected value.
      */
    public function testGphotoCommentingEnabled()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoCommentingEnabled() instanceof \ZendGData\Photos\Extension\CommentingEnabled);
        $this->verifyProperty2($entry, "gphotoCommentingEnabled", "text",
                "true");
        $this->verifyProperty3($entry, "gphotoCommentingEnabled", "text",
                "true");
    }

    /**
      * Check for the existence of an <gphoto:commentCount> and verify that it contains
      * the expected value.
      */
    public function testGphotoCommentCount()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's title is correct
        $this->assertTrue($entry->getGphotoCommentCount() instanceof \ZendGData\Photos\Extension\CommentCount);
        $this->verifyProperty2($entry, "gphotoCommentCount", "text",
                "0");
        $this->verifyProperty3($entry, "gphotoCommentCount", "text",
                "0");
    }

    /**
      * Check for the existence of a <media:group>
      */
    public function testMediaGroup()
    {
        $entry = $this->albumEntry;

        // Assert that the entry's media group exists
        $this->assertTrue($entry->getMediaGroup() instanceof \ZendGData\Media\Extension\MediaGroup);
    }

    /**
     * Check for the geo data and verify that it contains the expected values
     */
    public function testGeoData()
    {
        $geoRssWhere = $this->albumEntry->geoRssWhere;
        $point = $geoRssWhere->point;
        $pos = $point->pos;
        $this->assertEquals("42.87194 13.56738", $pos->text);
    }

}
