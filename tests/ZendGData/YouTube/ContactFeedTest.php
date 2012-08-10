<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\YouTube;

use ZendGData\YouTube;

/**
 * @category   Zend
 * @package    ZendGData\YouTube
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\YouTube
 */
class ContactFeedTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->feedText = file_get_contents(
                'ZendGData/YouTube/_files/ContactFeedDataSample1.xml',
                true);
        $this->feed = new YouTube\ContactFeed();
    }

    private function verifyAllSamplePropertiesAreCorrect ($contactFeed)
    {
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic/contacts',
            $contactFeed->id->text);
        $this->assertEquals('2007-09-21T02:44:41.135Z', $contactFeed->updated->text);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $contactFeed->category[0]->scheme);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007#friend', $contactFeed->category[0]->term);
        $this->assertEquals('http://www.youtube.com/img/pic_youtubelogo_123x63.gif', $contactFeed->logo->text);
        $this->assertEquals('text', $contactFeed->title->type);
        $this->assertEquals('davidchoimusic\'s Contacts', $contactFeed->title->text);
        $this->assertEquals('self', $contactFeed->getLink('self')->rel);
        $this->assertEquals('application/atom+xml', $contactFeed->getLink('self')->type);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic/contacts?start-index=1&max-results=5', $contactFeed->getLink('self')->href);
        $this->assertEquals('davidchoimusic', $contactFeed->author[0]->name->text);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic', $contactFeed->author[0]->uri->text);
        $this->assertEquals(1558, $contactFeed->totalResults->text);
        $this->assertEquals(1, $contactFeed->startIndex->text);
        $this->assertEquals(5, $contactFeed->itemsPerPage->text);
    }

    public function testEmptyEntryShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->feed->extensionElements));
        $this->assertTrue(count($this->feed->extensionElements) == 0);
    }

    public function testEmptyEntryShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->feed->extensionAttributes));
        $this->assertTrue(count($this->feed->extensionAttributes) == 0);
    }

    public function testSampleEntryShouldHaveNoExtensionElements()
    {
        $this->feed->transferFromXML($this->feedText);
        $this->assertTrue(is_array($this->feed->extensionElements));
        $this->assertTrue(count($this->feed->extensionElements) == 0);
    }

    public function testSampleEntryShouldHaveNoExtensionAttributes()
    {
        $this->feed->transferFromXML($this->feedText);
        $this->assertTrue(is_array($this->feed->extensionAttributes));
        $this->assertTrue(count($this->feed->extensionAttributes) == 0);
    }

    public function testEmptyContactFeedToAndFromStringShouldMatch()
    {
        $entryXml = $this->feed->saveXML();
        $newContactFeed = new YouTube\ContactFeed();
        $newContactFeed->transferFromXML($entryXml);
        $newContactFeedXml = $newContactFeed->saveXML();
        $this->assertTrue($entryXml == $newContactFeedXml);
    }

    public function testSamplePropertiesAreCorrect ()
    {
        $this->feed->transferFromXML($this->feedText);
        $this->verifyAllSamplePropertiesAreCorrect($this->feed);
    }

    public function testConvertContactFeedToAndFromString()
    {
        $this->feed->transferFromXML($this->feedText);
        $entryXml = $this->feed->saveXML();
        $newContactFeed = new YouTube\ContactFeed();
        $newContactFeed->transferFromXML($entryXml);
        $this->verifyAllSamplePropertiesAreCorrect($newContactFeed);
        $newContactFeedXml = $newContactFeed->saveXML();
        $this->assertEquals($entryXml, $newContactFeedXml);
    }

}
