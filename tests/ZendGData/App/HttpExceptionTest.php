<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\App;

use ZendGData\Spreadsheets;

/**
 * @category   Zend
 * @package    ZendGData\App
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\App
 */
class HttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    /** @var Spreadsheets */
    public $gdata;

    public function setUp()
    {
        if (!constant('TESTS_ZEND_GDATA_ONLINE_ENABLED')) {
            $this->markTestSkipped('ZendGData online tests are not enabled');
        }
        $user = constant('TESTS_ZEND_GDATA_CLIENTLOGIN_EMAIL');
        $pass = constant('TESTS_ZEND_GDATA_CLIENTLOGIN_PASSWORD');
        $this->sprKey = constant('TESTS_ZEND_GDATA_SPREADSHEETS_SPREADSHEETKEY');
        $this->wksId = constant('TESTS_ZEND_GDATA_SPREADSHEETS_WORKSHEETID');
        $service = Spreadsheets::AUTH_SERVICE_NAME;
        $client = \ZendGData\ClientLogin::getHttpClient($user, $pass, $service);
        $this->gdata = new Spreadsheets($client);
    }

    public function testGetRawResponseBody()
    {
        try {
            $rowData = array();
            $entry = $this->gdata->insertRow($rowData, $this->sprKey);
            $this->fail('Expecting ZendGData\App\HttpException');
        } catch (\ZendGData\App\HttpException $hExc) {
            $message = $hExc->getMessage();
            $this->assertEquals('Expected response code 200, got 400', $message);
            $body = $hExc->getRawResponseBody();
            $this->assertNotNull($body);
            $this->assertNotEquals(stripos($body,
                'Blank rows cannot be written; use delete instead.'), false);
        }
    }
}
