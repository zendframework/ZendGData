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

use ZendGData\App;
use Zend\Http\Header\Etag;

/**
 * @category   Zend
 * @package    ZendGData
 * @subpackage UnitTests
 * @group      ZendGData
 */
class EntryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->entry = new \ZendGData\Entry();
        $this->entryText = file_get_contents(
                'ZendGData/_files/EntrySample1.xml',
                true);
        $this->etagLocalName = 'etag';
        $this->expectedEtag = 'W/"CkcHQH8_fCp7ImA9WxRTGEw."';
        $this->expectedMismatchExceptionMessage = "ETag mismatch";
        $this->gdNamespace = 'http://schemas.google.com/g/2005';
        $this->openSearchNamespacev1 = 'http://a9.com/-/spec/opensearchrss/1.0/';
        $this->openSearchNamespacev2 = 'http://a9.com/-/spec/opensearch/1.1/';

    }

    public function testXMLHasNoEtagsWhenUsingV1()
    {
        $etagData = Etag::fromString('Etag: Quux');
        $this->entry->setEtag($etagData);
        $domNode = $this->entry->getDOM(null, 1, null);
        $this->assertNull($domNode->attributes->getNamedItemNS($this->gdNamespace, $this->etagLocalName));
    }

    public function testXMLHasNoEtagsWhenUsingV1X()
    {
        $etagData = Etag::fromString('Etag: Quux');
        $this->entry->setEtag($etagData);
        $domNode = $this->entry->getDOM(null, 1, 1);
        $this->assertNull($domNode->attributes->getNamedItemNS($this->gdNamespace, $this->etagLocalName));
    }

    public function testXMLHasEtagsWhenUsingV2()
    {
        $etagData = Etag::fromString('Etag: Quux');
        $this->entry->setEtag($etagData);
        $domNode = $this->entry->getDOM(null, 2, null);
        $this->assertEquals($etagData->getFieldValue(), $domNode->attributes->getNamedItemNS($this->gdNamespace, $this->etagLocalName)->nodeValue);
    }

    public function testXMLHasEtagsWhenUsingV2X()
    {
        $etagData = Etag::fromString('Etag: Quux');
        $this->entry->setEtag($etagData);
        $domNode = $this->entry->getDOM(null, 2, 1);
        $this->assertEquals($etagData->getFieldValue(), $domNode->attributes->getNamedItemNS($this->gdNamespace, $this->etagLocalName)->nodeValue);
    }

    public function testXMLETagsPropagateToEntry()
    {
        $this->entry->transferFromXML($this->entryText);
        $this->assertEquals($this->expectedEtag, $this->entry->getEtag());
    }

    public function testXMLandHTMLEtagsDifferingThrowsException()
    {
        $exceptionCaught = false;
        $this->entry->setEtag(Etag::fromString("Etag: Foo"));
        try {
            $this->entry->transferFromXML($this->entryText);
        } catch (App\IOException $e) {
            $exceptionCaught = true;
        }
        $this->assertTrue($exceptionCaught, "Exception ZendGData\\App\\IOException expected");
    }

    public function testHttpAndXmlEtagsDifferingThrowsExceptionWithMessage()
    {
        $messageCorrect = false;
        $this->entry->setEtag(Etag::fromString("Etag: Foo"));
        try {
            $this->entry->transferFromXML($this->entryText);
        } catch (App\IOException $e) {
            if ($e->getMessage() == $this->expectedMismatchExceptionMessage)
                $messageCorrect = true;
        }
        $this->assertTrue($messageCorrect, "Exception ZendGData\\App\\IOException message incorrect");
    }

    public function testNothingBadHappensWhenHttpAndXmlEtagsMatch()
    {
        $this->entry->setEtag(Etag::fromString('Etag: ' . $this->expectedEtag));
        $this->entry->transferFromXML($this->entryText);
        $this->assertEquals($this->expectedEtag, $this->entry->getEtag()->getFieldValue());
    }

    public function testLookUpOpenSearchv1Namespace()
    {
        $this->assertEquals($this->openSearchNamespacev1,
            $this->entry->lookupNamespace('openSearch', 1, 0));
        $this->assertEquals($this->openSearchNamespacev1,
            $this->entry->lookupNamespace('openSearch', 1, null));
    }

    public function testLookupOpenSearchv2Namespace()
    {
        $this->assertEquals($this->openSearchNamespacev2,
            $this->entry->lookupNamespace('openSearch', 2, 0));
        $this->assertEquals($this->openSearchNamespacev2,
            $this->entry->lookupNamespace('openSearch', 2, null));
    }

}
