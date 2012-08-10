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
class CommentEntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->entryText = file_get_contents(
                'ZendGData/YouTube/_files/CommentEntryDataSample1.xml',
                true);
        $this->entry = new YouTube\CommentEntry();
    }

    private function verifyAllSamplePropertiesAreCorrect ($commentEntry)
    {
        $this->assertEquals('http://gdata.youtube.com/feeds/videos/Lnio-pqLPgg/comments/CE0314DEBFFC9052',
            $commentEntry->id->text);
        $this->assertEquals('2007-09-02T18:00:04.000-07:00', $commentEntry->updated->text);
        $this->assertEquals('http://schemas.google.com/g/2005#kind', $commentEntry->category[0]->scheme);
        $this->assertEquals('http://gdata.youtube.com/schemas/2007#comment', $commentEntry->category[0]->term);
        $this->assertEquals('text', $commentEntry->title->type);
        $this->assertEquals('how to turn ...', $commentEntry->title->text);
        $this->assertEquals('text', $commentEntry->content->type);
        $this->assertEquals('how to turn rejection and heartbreak into something positive is the big mystery of life but you\'re managed to turn it to your advantage with a beautiful song. Who was she?', $commentEntry->content->text);
        $this->assertEquals('self', $commentEntry->getLink('self')->rel);
        $this->assertEquals('application/atom+xml', $commentEntry->getLink('self')->type);
        $this->assertEquals('http://gdata.youtube.com/feeds/videos/Lnio-pqLPgg/comments/CE0314DEBFFC9052', $commentEntry->getLink('self')->href);
        $this->assertEquals('reneemathome', $commentEntry->author[0]->name->text);
        $this->assertEquals('http://gdata.youtube.com/feeds/users/reneemathome', $commentEntry->author[0]->uri->text);
    }

    public function testEmptyEntryShouldHaveNoExtensionElements()
    {
        $this->assertTrue(is_array($this->entry->extensionElements));
        $this->assertTrue(count($this->entry->extensionElements) == 0);
    }

    public function testEmptyEntryShouldHaveNoExtensionAttributes()
    {
        $this->assertTrue(is_array($this->entry->extensionAttributes));
        $this->assertTrue(count($this->entry->extensionAttributes) == 0);
    }

    public function testSampleEntryShouldHaveNoExtensionElements()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->assertTrue(is_array($this->entry->extensionElements));
        $this->assertTrue(count($this->entry->extensionElements) == 0);
    }

    public function testSampleEntryShouldHaveNoExtensionAttributes()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->assertTrue(is_array($this->entry->extensionAttributes));
        $this->assertTrue(count($this->entry->extensionAttributes) == 0);
    }

    public function testEmptyCommentEntryToAndFromStringShouldMatch()
    {
        $entryXml = $this->entry->saveXML();
        $newCommentEntry = new YouTube\CommentEntry();
        $newCommentEntry->transferFromXML($entryXml);
        $newCommentEntryXml = $newCommentEntry->saveXML();
        $this->assertTrue($entryXml == $newCommentEntryXml);
    }

    public function testSamplePropertiesAreCorrect ()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->verifyAllSamplePropertiesAreCorrect($this->entry);
    }

    public function testConvertCommentEntryToAndFromString()
    {
        $this->entry->transferFromXML($this->entryText);
        $entryXml = $this->entry->saveXML();
        $newCommentEntry = new YouTube\CommentEntry();
        $newCommentEntry->transferFromXML($entryXml);
        $this->verifyAllSamplePropertiesAreCorrect($newCommentEntry);
        $newCommentEntryXml = $newCommentEntry->saveXML();
        $this->assertEquals($entryXml, $newCommentEntryXml);
    }

}
