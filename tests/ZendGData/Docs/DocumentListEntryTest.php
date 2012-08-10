<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Docs;

use ZendGData\Docs;

/**
 * @category   Zend
 * @package    ZendGData\Docsj
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Docsj
 */
class DocumentListEntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->doc = new Docs\DocumentListEntry(
                file_get_contents('ZendGData/Docs/_files/TestDataDocumentListEntrySample.xml', true));
    }

    public function testToAndFromString()
    {
        $this->assertTrue($this->doc instanceof Docs\DocumentListEntry);
        $this->assertTrue($this->doc->title->text === 'Test Spreadsheet');

        $newDoc = new Docs\DocumentListEntry();
        $doc = new \DOMDocument();
        $doc->loadXML($this->doc->saveXML());
        $newDoc->transferFromDom($doc->documentElement);

        $this->assertTrue($newDoc->title == $this->doc->title);
    }

    public function testSetMediaSource()
    {
        // Service object to create the media file source.
        $this->docsClient = new Docs(null);
        $mediaSource = $this->docsClient->newMediaFileSource('test_file_name');
        $mediaSource->setSlug('test slug');
        $mediaSource->setContentType('test content type');
        $this->doc->setMediaSource($mediaSource);
        $this->assertTrue($this->doc->getMediaSource()->getContentType() ===
            'test content type');
        $this->assertTrue($this->doc->getMediaSource()->getSlug() ===
            'test slug');
    }

}
