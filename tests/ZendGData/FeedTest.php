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
class FeedTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->etagLocalName = 'etag';
        $this->expectedEtag = 'W/"CE4BRXw4cCp7ImA9WxRVFEs."';
        $this->expectedMismatchExceptionMessage = "ETag mismatch";
        $this->feed = new \ZendGData\Feed();
        $this->feedTextV1 = file_get_contents(
                'ZendGData/_files/FeedSampleV1.xml',
                true);
        $this->feedTextV2 = file_get_contents(
                'ZendGData/_files/FeedSampleV2.xml',
                true);
        $this->gdNamespace = 'http://schemas.google.com/g/2005';
        $this->openSearchNamespacev1 = 'http://a9.com/-/spec/opensearchrss/1.0/';
        $this->openSearchNamespacev2 = 'http://a9.com/-/spec/opensearch/1.1/';
    }

    public function testXMLHasNoEtagsWhenUsingV1()
    {
        $etagData = Etag::fromString('Etag: Quux');
        $this->feed->setEtag($etagData);
        $domNode = $this->feed->getDOM(null, 1, null);
        $this->assertNull(
            $domNode->attributes->getNamedItemNS(
                $this->gdNamespace, $this->etagLocalName));
    }

    public function testXMLHasNoEtagsWhenUsingV1X()
    {
        $etagData = Etag::fromString('Etag: Quux');
        $this->feed->setEtag($etagData);
        $domNode = $this->feed->getDOM(null, 1, 1);
        $this->assertNull(
            $domNode->attributes->getNamedItemNS(
                $this->gdNamespace, $this->etagLocalName));
    }

    public function testXMLHasEtagsWhenUsingV2()
    {
        $etagData = Etag::fromString('Etag: Quux');
        $this->feed->setEtag($etagData);
        $domNode = $this->feed->getDOM(null, 2, null);
        $this->assertEquals(
            $etagData->getFieldValue(),
            $domNode->attributes->getNamedItemNS(
                $this->gdNamespace, $this->etagLocalName)->nodeValue);
    }

    public function testXMLHasEtagsWhenUsingV2X()
    {
        $etagData = Etag::fromString('Etag: Quux');
        $this->feed->setEtag($etagData);
        $domNode = $this->feed->getDOM(null, 2, 1);
        $this->assertEquals(
            $etagData->getFieldValue(),
            $domNode->attributes->getNamedItemNS(
                $this->gdNamespace, $this->etagLocalName)->nodeValue);
    }

    public function testXMLETagsPropagateToFeed()
    {
        $this->feed->transferFromXML($this->feedTextV2);
        $etagValue = $this->feed->getEtag();
        $this->assertEquals($this->expectedEtag, $this->feed->getEtag());
    }

    public function testXMLandHTMLEtagsDifferingThrowsException()
    {
        $exceptionCaught = false;
        $this->feed->setEtag(Etag::fromString("Etag: Foo"));
        try {
            $this->feed->transferFromXML($this->feedTextV2);
        } catch (App\IOException $e) {
            $exceptionCaught = true;
        }
        $this->assertTrue($exceptionCaught, "Exception ZendGData\\App\\IOException expected");
    }

    public function testHttpAndXmlEtagsDifferingThrowsExceptionWithMessage()
    {
        $messageCorrect = false;
        $this->feed->setEtag(Etag::fromString("Etag: Foo"));
        try {
            $this->feed->transferFromXML($this->feedTextV2);
        } catch (App\IOException $e) {
            if ($e->getMessage() == $this->expectedMismatchExceptionMessage)
                $messageCorrect = true;
        }
        $this->assertTrue($messageCorrect, "Exception ZendGData\\App\\IOException message incorrect");
    }

    public function testNothingBadHappensWhenHttpAndXmlEtagsMatch()
    {
        $this->feed->setEtag(Etag::fromString('Etag: ' . $this->expectedEtag));
        $this->feed->transferFromXML($this->feedTextV2);
        $this->assertEquals($this->expectedEtag, $this->feed->getEtag()->getFieldValue());
    }

    public function testLookUpOpenSearchv1Namespace()
    {
        $this->feed->setMajorProtocolVersion(1);
        $this->feed->setMinorProtocolVersion(0);
        $this->assertEquals($this->openSearchNamespacev1,
            $this->feed->lookupNamespace('openSearch', 1));
        $this->feed->setMinorProtocolVersion(null);
        $this->assertEquals($this->openSearchNamespacev1,
            $this->feed->lookupNamespace('openSearch', 1));
    }

    public function testLookupOpenSearchv2Namespace()
    {
        $this->feed->setMajorProtocolVersion(2);
        $this->feed->setMinorProtocolVersion(0);
        $this->assertEquals($this->openSearchNamespacev2,
            $this->feed->lookupNamespace('openSearch'));
        $this->feed->setMinorProtocolVersion(null);
        $this->assertEquals($this->openSearchNamespacev2,
            $this->feed->lookupNamespace('openSearch'));
    }

    public function testNoExtensionElementsInV1Feed()
    {
        $this->feed->setMajorProtocolVersion(1);
        $this->feed->transferFromXML($this->feedTextV1);
        $this->assertEquals(0, sizeof($this->feed->extensionElements));
    }

    public function testNoExtensionElementsInV2Feed()
    {
        $this->feed->setMajorProtocolVersion(2);
        $this->feed->transferFromXML($this->feedTextV2);
        $this->assertEquals(0, sizeof($this->feed->extensionElements));
    }
}
