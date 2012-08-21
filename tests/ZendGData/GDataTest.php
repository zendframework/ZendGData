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

use ZendGData\GData;
use Zend\Http;

/**
 * @category   Zend
 * @package    ZendGData
 * @subpackage UnitTests
 * @group      ZendGData
 */
class GDataTest extends \PHPUnit_Framework_TestCase
{

    public function testDefaultHttpClient()
    {
        $gdata = new GData();
        $client = $gdata->getHttpClient();
        $this->assertTrue($client instanceof Http\Client,
            'Expecting object of type Zend_Http_Client, got '
            . (gettype($client) == 'object' ? get_class($client) : gettype($client))
        );
    }

    public function testSpecificHttpClient()
    {
        $client = new Http\Client();
        $gdata = new GData($client);
        $client2 = $gdata->getHttpClient();
        $this->assertTrue($client2 instanceof Http\Client,
            'Expecting object of type Zend_Http_Client, got '
            . (gettype($client) == 'object' ? get_class($client) : gettype($client))
        );
        $this->assertSame($client, $client2);
    }

    public function testGetFeedExceptionInvalidLocationType()
    {
        $gdata = new GData();
        try {
            // give it neither a string nor a ZendGData\Query object,
            // and see if it throws an exception.
            $feed = $gdata->getFeed(new \stdClass());
            $this->fail('Expecting to catch ZendGData\App\InvalidArgumentException');
        } catch (\Exception $e) {
            $this->assertInstanceOf('ZendGData\App\InvalidArgumentException', $e,
                'Expecting ZendGData\App\InvalidArgumentException, got '.get_class($e));
            $this->assertEquals('You must specify the location as either a string URI or a child of ZendGData\Query', $e->getMessage());
        }
    }

    public function testGetEntryExceptionInvalidLocationType()
    {
        $gdata = new GData();
        try {
            // give it neither a string nor a ZendGData\Query object,
            // and see if it throws an exception.
            $feed = $gdata->getEntry(new \stdClass());
            $this->fail('Expecting to catch ZendGData\App\InvalidArgumentException');
        } catch (\Exception $e) {
            $this->assertInstanceOf('ZendGData\App\InvalidArgumentException', $e,
                'Expecting ZendGData\App\InvalidArgumentException, got '.get_class($e));
            $this->assertEquals('You must specify the location as either a string URI or a child of ZendGData\Query', $e->getMessage());
        }
    }

}
