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
use ZendGData\Extension;
use ZendGData\App;

/**
 * @category   Zend
 * @package    ZendGData\YouTube
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\YouTube
 */
class PlaylistListEntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->v2entryText = file_get_contents(
                'ZendGData/YouTube/_files/PlaylistListEntryDataSampleV2.xml',
                true);
        $this->entry = new YouTube\PlaylistListEntry();
    }

    private function verifyAllSamplePropertiesAreCorrect ($playlistListEntry)
    {
        $this->assertEquals('http://gdata.youtube.com/feeds/users/testuser/playlists/46A2F8C9B36B6FE7',
            $playlistListEntry->id->text);
        $this->assertEquals('2007-09-20T13:42:19.000-07:00', $playlistListEntry->updated->text);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007/tags.cat', $playlistListEntry->category[0]->scheme);
        $this->assertEquals('music', $playlistListEntry->category[0]->term);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $playlistListEntry->category[1]->scheme);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007#playlistLink', $playlistListEntry->category[1]->term);
        $this->assertEquals('text', $playlistListEntry->title->type);
        $this->assertEquals('YouTube Musicians', $playlistListEntry->title->text);
        $this->assertEquals('text', $playlistListEntry->content->type);
        $this->assertEquals('Music from talented people on YouTube.', $playlistListEntry->content->text);
        $this->assertEquals('self', $playlistListEntry->getLink('self')->rel);
        $this->assertEquals('application/atom+xml', $playlistListEntry->getLink('self')->type);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/testuser/playlists/46A2F8C9B36B6FE7', $playlistListEntry->getLink('self')->href);
        $this->assertEquals('testuser', $playlistListEntry->author[0]->name->text);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/testuser', $playlistListEntry->author[0]->uri->text);
        $this->assertEquals('Music from talented people on YouTube.', $playlistListEntry->description->text);
        $this->assertEquals('http://gdata.youtube.com/feeds/playlists/46A2F8C9B36B6FE7', $playlistListEntry->getPlaylistVideoFeedUrl());
        $this->assertEquals('http://gdata.youtube.com/feeds/playlists/46A2F8C9B36B6FE7', $playlistListEntry->feedLink[0]->href);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007#playlist', $playlistListEntry->feedLink[0]->rel);
    }

    private function verifyAllSamplePropertiesAreCorrectV2 ($playlistListEntry)
    {
        $this->assertEquals('tag:youtube.com,2008:user:googledevelopers:playlist:8E2186857EE27746',
            $playlistListEntry->id->text);
        $this->assertEquals('2008-12-10T09:56:03.000Z', $playlistListEntry->updated->text);
        $this->assertEquals('2007-08-23T21:48:43.000Z', $playlistListEntry->published->text);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $playlistListEntry->category[0]->scheme);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007#playlistLink', $playlistListEntry->category[0]->term);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $playlistListEntry->category[0]->scheme);
        $this->assertEquals('Non-google Interviews', $playlistListEntry->title->text);
        $this->assertEquals('This playlist contains interviews with people outside of Google.', $playlistListEntry->summary->text);

        $this->assertEquals('self', $playlistListEntry->getLink('self')->rel);
        $this->assertEquals('http://gdata.youtube.com/feeds/api/users/googledevelopers/playlists/8E2186857EE27746?v=2', $playlistListEntry->getLink('self')->href);
        $this->assertEquals('application/atom+xml', $playlistListEntry->getLink('self')->type);
        $this->assertEquals('alternate', $playlistListEntry->getLink('alternate')->rel);
        $this->assertEquals('http://www.youtube.com/view_play_list?p=8E2186857EE27746', $playlistListEntry->getLink('alternate')->href);
        $this->assertEquals('text/html', $playlistListEntry->getLink('alternate')->type);
        $this->assertEquals('related', $playlistListEntry->getLink('related')->rel);
        $this->assertEquals('http://gdata.youtube.com/feeds/api/users/googledevelopers?v=2', $playlistListEntry->getLink('related')->href);
        $this->assertEquals('application/atom+xml', $playlistListEntry->getLink('related')->type);
        $this->assertEquals('googledevelopers', $playlistListEntry->author[0]->name->text);
        $this->assertEquals('http://gdata.youtube.com/feeds/api/users/googledevelopers', $playlistListEntry->author[0]->uri->text);

        $this->assertEquals('8E2186857EE27746', $playlistListEntry->getPlaylistId()->text);
        $this->assertEquals('1', $playlistListEntry->getCountHint()->text);

        $this->assertEquals('application/atom+xml;type=feed', $playlistListEntry->getContent()->getType());
        $this->assertEquals('http://gdata.youtube.com/feeds/api/playlists/8E2186857EE27746?v=2', $playlistListEntry->getContent()->getSrc());
    }

    public function testEmptyEntryShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->entry->extensionElements));
        $this->assertEquals(0, count($this->entry->extensionElements));
    }

    public function testEmptyEntryShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->entry->extensionAttributes));
        $this->assertEquals(0, count($this->entry->extensionAttributes));
    }

    public function testEmptyPlaylistListEntryToAndFromStringShouldMatch()
    {
        $entryXml = $this->entry->saveXML();
        $newPlaylistListEntry = new YouTube\PlaylistListEntry();
        $newPlaylistListEntry->transferFromXML($entryXml);
        $newPlaylistListEntryXml = $newPlaylistListEntry->saveXML();
        $this->assertTrue($entryXml == $newPlaylistListEntryXml);
    }


    public function testGetFeedLinkReturnsAllStoredEntriesWhenUsedWithNoParameters()
    {
        // Prepare test data
        $entry1 = new Extension\FeedLink();
        $entry1->rel = "first";
        $entry1->href= "foo";
        $entry2 = new Extension\FeedLink();
        $entry2->rel = "second";
        $entry2->href= "bar";
        $data = array($entry1, $entry2);

        // Load test data and run test
        $this->entry->feedLink = $data;
        $this->assertEquals(2, count($this->entry->feedLink));
    }

    public function testGetFeedLinkCanReturnEntriesByRelValue()
    {
        // Prepare test data
        $entry1 = new Extension\FeedLink();
        $entry1->rel = "first";
        $entry1->href= "foo";
        $entry2 = new Extension\FeedLink();
        $entry2->rel = "second";
        $entry2->href= "bar";
        $data = array($entry1, $entry2);

        // Load test data and run test
        $this->entry->feedLink = $data;
        $this->assertEquals($entry1, $this->entry->getFeedLink('first'));
        $this->assertEquals($entry2, $this->entry->getFeedLink('second'));
    }

    public function testSamplePropertiesAreCorrectV2 ()
    {
        $this->entry->transferFromXML($this->v2entryText);
        $this->entry->setMajorProtocolVersion(2);
        $this->verifyAllSamplePropertiesAreCorrectV2($this->entry);
    }

    public function testConvertPlaylistListEntryToAndFromStringV2()
    {
        $this->entry->transferFromXML($this->v2entryText);
        $entryXml = $this->entry->saveXML();
        $newPlaylistListEntry = new YouTube\PlaylistListEntry();
        $newPlaylistListEntry->transferFromXML($entryXml);
        $newPlaylistListEntry->setMajorProtocolVersion(2);
        $this->verifyAllSamplePropertiesAreCorrectV2($newPlaylistListEntry);
        $newPlaylistListEntryXml = $newPlaylistListEntry->saveXML();
        $this->assertEquals($entryXml, $newPlaylistListEntryXml);
    }

    public function testGetPlaylistVideoFeedUrlWorksInV2()
    {
        $this->entry->transferFromXML($this->v2entryText);
        $this->entry->setMajorProtocolVersion(2);
        $this->assertEquals(
            'http://gdata.youtube.com/feeds/api/playlists/8E2186857EE27746?v=2',
            $this->entry->getPlaylistVideoFeedUrl());
    }
}
