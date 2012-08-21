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

use DOMDocument;
use ZendGData\Docs\DocumentListFeed;

/**
 * @category   Zend
 * @package    ZendGData\Docs
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Docs
 */
class DocumentListFeedTest extends \PHPUnit_Framework_TestCase
{

    /** @var DocumentListFeed */
    public $docFeed;

    public function setUp()
    {
        $this->docFeed = new DocumentListFeed(
                file_get_contents(__DIR__ . '/_files/TestDataDocumentListFeedSample.xml'),
                true);
    }

    public function testToAndFromString()
    {
        // There should be 2 entries in the feed.
        $this->assertEquals(2, count($this->docFeed->entries));
        $this->assertEquals(2, $this->docFeed->entries->count());
        foreach($this->docFeed->entries as $entry) {
            $this->assertInstanceOf('ZendGData\Docs\DocumentListEntry', $entry);
        }

        $newDocFeed = new DocumentListFeed();
        $doc = new DOMDocument();
        $doc->loadXML($this->docFeed->saveXML());
        $newDocFeed->transferFromDom($doc->documentElement);

        $this->assertEquals(count($newDocFeed->entries), count($this->docFeed->entries));
        foreach($newDocFeed->entries as $entry) {
            $this->assertInstanceOf('ZendGData\Docs\DocumentListEntry', $entry);
        }
    }

}
