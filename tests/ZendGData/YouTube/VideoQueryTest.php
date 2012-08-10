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
use ZendGData\App;

/**
 * @category   Zend
 * @package    ZendGData\YouTube
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\YouTube
 */
class VideoQueryTest extends \PHPUnit_Framework_TestCase
{

    public function testQueryStringConstructionV2()
    {
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $query->setOrderBy('viewCount');
        $query->setVideoQuery('version2');
        $expectedString = '?orderby=viewCount&q=version2';
        $this->assertEquals($expectedString, $query->getQueryString(2));
    }

    public function testLocationV2()
    {
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $query->setLocation('-37.122,122.01');
        $expectedString = '?location=-37.122%2C122.01';
        $this->assertEquals($expectedString, $query->getQueryString(2));
    }

    public function testLocationExceptionOnNonNumericV2()
    {
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $exceptionCaught = false;

        try {
            $query->setLocation('mars');
        } catch (App\InvalidArgumentException $e) {
            $exceptionCaught = true;
        }

        $this->assertTrue($exceptionCaught, 'Expected ZendGData\App\\' .
            'IllegalArgumentException when using alpha in setLocation');
    }

    public function testLocationExceptionOnOnlyOneCoordinateV2()
    {
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $exceptionCaught = false;

        try {
            $query->setLocation('-25.001');
        } catch (App\InvalidArgumentException $e) {
            $exceptionCaught = true;
        }

        $this->assertTrue($exceptionCaught, 'Expected ZendGData\App\\' .
            'IllegalArgumentException when using only 1 coordinate ' .
            'in setLocation');
    }

    public function testUploaderExceptionOnInvalidV2()
    {
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $exceptionCaught = false;

        try {
            $query->setUploader('invalid');
        } catch (App\InvalidArgumentException $e) {
            $exceptionCaught = true;
        }

        $this->assertTrue($exceptionCaught, 'Expected ZendGData\App\\' .
            'IllegalArgumentException when using invalid string in ' .
            'setUploader.');
    }

    public function testProjectionPresentInV2Query()
    {
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $query->setVideoQuery('foo');
        $expectedString = 'https://gdata.youtube.com/feeds/api/videos?q=foo';
        $this->assertEquals($expectedString, $query->getQueryUrl(2));
    }

    public function testSafeSearchParametersInV2()
    {
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $exceptionCaught = false;
        try {
            $query->setSafeSearch('invalid');
        } catch (App\InvalidArgumentException $e) {
            $exceptionCaught = true;
        }
        $this->assertTrue($exceptionCaught, 'Expected ZendGData\App\\' .
            'InvalidArgumentException when using invalid value for ' .
            'safeSearch.');
    }

    /**
     * @group ZF-8720
     */
    public function testVideoQuerySetLocationException()
    {
        $this->setExpectedException('ZendGData\App\InvalidArgumentException');
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $location = 'foobar';
        $this->assertNull($query->setLocation($location));
    }

    /**
     * @group ZF-8720
     */
    public function testVideoQuerySetLocationExceptionV2()
    {
        $this->setExpectedException('ZendGData\App\InvalidArgumentException');
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $location = '-100x,-200y';
        $this->assertNull($query->setLocation($location));
    }

    /**
     * @group ZF-8720
     */
    public function testVideoQuerySetLocationExceptionV3()
    {
        $this->setExpectedException('ZendGData\App\InvalidArgumentException');
        $yt = new YouTube();
        $query = $yt->newVideoQuery();
        $location = '-100x,-200y!';
        $this->assertNull($query->setLocation($location));
    }

    /**
     * @group ZF-8720
     */
    public function testQueryExclamationMarkRemoveBug()
    {
        $yt = new YouTube();
        $query = $yt->newVideoQuery();

        $location = '37.42307,-122.08427';
        $this->assertNull($query->setLocation($location));
        $this->assertEquals($location, $query->getLocation());

        $location = '37.42307,-122.08427!';
        $this->assertNull($query->setLocation($location));
        $this->assertEquals($location, $query->getLocation());
    }

    /**
     * test related to ZF2-303
     */
    public function testQueryWithGetFeed()
    {
        if (!constant('TESTS_ZEND_GDATA_ONLINE_ENABLED')) {
            $this->markTestSkipped('ZendGData online tests are not enabled');
        }
        $youtube           = new YouTube();
        $query             = $youtube->newVideoQuery();
        $query->videoQuery = 'php';
        $query->startIndex = 0;
        $query->maxResults = 20;
        $query->orderBy    = 'viewCount';
        $videoFeed         = $youtube->getVideoFeed($query);
        $this->assertTrue($videoFeed->count() > 10);
    }
}
