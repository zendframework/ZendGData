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
class VideoFeedTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->feedText = file_get_contents(
                'ZendGData/YouTube/_files/VideoFeedDataSample1.xml',
                true);
        $this->feed = new YouTube\VideoFeed();
    }

    private function verifyAllSamplePropertiesAreCorrect ($videoFeed)
    {
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic/uploads',
            $videoFeed->id->text);
        $this->assertEquals('2007-09-21T02:27:22.638Z', $videoFeed->updated->text);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $videoFeed->category[0]->scheme);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007#video', $videoFeed->category[0]->term);
        $this->assertEquals('http://www.youtube.com/img/pic_youtubelogo_123x63.gif', $videoFeed->logo->text);
        $this->assertEquals('text', $videoFeed->title->type);
        $this->assertEquals('Davidchoimusic\'s Videos', $videoFeed->title->text);
        $this->assertEquals('self', $videoFeed->getLink('self')->rel);
        $this->assertEquals('application/atom+xml', $videoFeed->getLink('self')->type);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic/uploads?start-index=1&max-results=5', $videoFeed->getLink('self')->href);
        $this->assertEquals('davidchoimusic', $videoFeed->author[0]->name->text);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/davidchoimusic', $videoFeed->author[0]->uri->text);
        $this->assertEquals(54, $videoFeed->totalResults->text);
        $this->assertEquals(1, $videoFeed->startIndex->text);
        $this->assertEquals(5, $videoFeed->itemsPerPage->text);
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

    public function testEmptyVideoFeedToAndFromStringShouldMatch()
    {
        $entryXml = $this->feed->saveXML();
        $newVideoFeed = new YouTube\VideoFeed();
        $newVideoFeed->transferFromXML($entryXml);
        $newVideoFeedXml = $newVideoFeed->saveXML();
        $this->assertTrue($entryXml == $newVideoFeedXml);
    }

    public function testSamplePropertiesAreCorrect ()
    {
        $this->feed->transferFromXML($this->feedText);
        $this->verifyAllSamplePropertiesAreCorrect($this->feed);
    }

    public function testConvertVideoFeedToAndFromString()
    {
        $this->feed->transferFromXML($this->feedText);
        $entryXml = $this->feed->saveXML();
        $newVideoFeed = new YouTube\VideoFeed();
        $newVideoFeed->transferFromXML($entryXml);
        $this->verifyAllSamplePropertiesAreCorrect($newVideoFeed);
        $newVideoFeedXml = $newVideoFeed->saveXML();
        $this->assertEquals($entryXml, $newVideoFeedXml);
    }

}
