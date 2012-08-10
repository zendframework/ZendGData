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

use ZendGData\AuthSub;
use ZendGData\HttpClient;
use Zend\Http\Client;
use Zend\Http\Client\Adapter\Test as AdapterTest;

/**
 * @category   Zend
 * @package    ZendGData
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\AuthSub
 */
class AuthSubTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Dummy token used during testing
     * @var string
     */
    protected $token = 'DQAAFPHOW7DCTN';

    public function testNormalGetAuthSubTokenUri()
    {
        $uri = AuthSub::getAuthSubTokenUri(
                'http://www.example.com/foo.php', //next
                'http://www.google.com/calendar/feeds', //scope
                0, //secure
                1); //session

        // Note: the scope here is not encoded.  It should be encoded,
        // but the method getAuthSubTokenUri calls urldecode($scope).
        // This currently works (no reported bugs) as web browsers will
        // handle the encoding in most cases.
       $this->assertEquals('https://www.google.com/accounts/AuthSubRequest?next=http%3A%2F%2Fwww.example.com%2Ffoo.php&scope=http://www.google.com/calendar/feeds&secure=0&session=1', $uri);
    }

    public function testGetAuthSubTokenUriModifiedBase()
    {
        $uri = AuthSub::getAuthSubTokenUri(
                'http://www.example.com/foo.php', //next
                'http://www.google.com/calendar/feeds', //scope
                0, //secure
                1, //session
                'http://www.otherauthservice.com/accounts/AuthSubRequest');

        // Note: the scope here is not encoded.  It should be encoded,
        // but the method getAuthSubTokenUri calls urldecode($scope).
        // This currently works (no reported bugs) as web browsers will
        // handle the encoding in most cases.
       $this->assertEquals('http://www.otherauthservice.com/accounts/AuthSubRequest?next=http%3A%2F%2Fwww.example.com%2Ffoo.php&scope=http://www.google.com/calendar/feeds&secure=0&session=1', $uri);
    }

    public function testSecureAuthSubSigning()
    {
        if (!extension_loaded('openssl')) {
            $this->markTestSkipped('The openssl extension is not available');
        } else {
            $c = new HttpClient();
            $c->setAuthSubPrivateKeyFile("Zend/GData/_files/RsaKey.pem",
                                         null, true);
            $c->setAuthSubToken('abcdefg');
            $requestData = $c->filterHttpRequest('POST',
                                                 'http://www.example.com/feed',
                                                  array(),
                                                  'foo bar',
                                                  'text/plain');

            $authHeaderCheckPassed = false;
            $headers = $requestData['headers'];
            foreach ($headers as $headerName => $headerValue) {
                if (strtolower($headerName) == 'authorization') {
                    preg_match('/data="([^"]*)"/', $headerValue, $matches);
                    $dataToSign = $matches[1];
                    preg_match('/sig="([^"]*)"/', $headerValue, $matches);
                    $sig = $matches[1];
                    if (function_exists('openssl_verify')) {
                        $fp = fopen('ZendGData/_files/RsaCert.pem', 'r', true);
                        $cert = '';
                        while (!feof($fp)) {
                            $cert .= fread($fp, 8192);
                        }
                        fclose($fp);
                        $pubkeyid = openssl_get_publickey($cert);
                        $verified = openssl_verify($dataToSign,
                                               base64_decode($sig), $pubkeyid);
                        $this->assertEquals(
                            1, $verified,
                            'The generated signature was unable ' .
                            'to be verified.');
                        $authHeaderCheckPassed = true;
                    }
                }
            }
            $this->assertEquals(true, $authHeaderCheckPassed,
                                'Auth header not found for sig verification.');
        }
    }

    public function testPrivateKeyNotFound()
    {
        $this->setExpectedException('ZendGData\App\InvalidArgumentException');

        if (!extension_loaded('openssl')) {
            $this->markTestSkipped('The openssl extension is not available');
        } else {
            $c = new HttpClient();
            $c->setAuthSubPrivateKeyFile("zendauthsubfilenotfound",  null, true);
        }
    }
    public function testAuthSubSessionTokenReceivesSuccessfulResult()
    {
        $adapter = new AdapterTest();
        $adapter->setResponse("HTTP/1.1 200 OK\r\n\r\nToken={$this->token}\r\nExpiration=20201004T123456Z");

        $client = new HttpClient();
        $client->setUri('http://example.com/AuthSub');
        $client->setAdapter($adapter);

        $respToken = AuthSub::getAuthSubSessionToken($this->token, $client);
        $this->assertEquals($this->token, $respToken);
    }

    /**
     * @expectedException ZendGData\App\AuthException
     */
    public function testAuthSubSessionTokenCatchesFailedResult()
    {
        $adapter = new AdapterTest();
        $adapter->setResponse("HTTP/1.1 500 Internal Server Error\r\n\r\nInternal Server Error");

        $client = new HttpClient();
        $client->setUri('http://example.com/AuthSub');
        $client->setAdapter($adapter);

        $newtok = AuthSub::getAuthSubSessionToken($this->token, $client);
    }

    /**
     * @expectedException ZendGData\App\HttpException
     */
    public function testAuthSubSessionTokenCatchesHttpClientException()
    {
        $adapter = new AdapterTest();
        $adapter->setNextRequestWillFail(true);

        $client = new HttpClient();
        $client->setUri('http://example.com/AuthSub');
        $client->setAdapter($adapter);

        $newtok = AuthSub::getAuthSubSessionToken($this->token, $client);
    }

    public function testAuthSubRevokeTokenReceivesSuccessfulResult()
    {
        $adapter = new AdapterTest();
        $adapter->setResponse("HTTP/1.1 200 OK");

        $client = new HttpClient();
        $client->setUri('http://example.com/AuthSub');
        $client->setAdapter($adapter);

        $revoked = AuthSub::AuthSubRevokeToken($this->token, $client);
        $this->assertTrue($revoked);
    }

    public function testAuthSubRevokeTokenCatchesFailedResult()
    {
        $adapter = new AdapterTest();
        $adapter->setResponse("HTTP/1.1 500 Not Successful");

        $client = new HttpClient();
        $client->setUri('http://example.com/AuthSub');
        $client->setAdapter($adapter);

        $revoked = AuthSub::AuthSubRevokeToken($this->token, $client);
        $this->assertFalse($revoked);
    }

    /**
     * @expectedException ZendGData\App\HttpException
     */
    public function testAuthSubRevokeTokenCatchesHttpClientException()
    {
        $adapter = new AdapterTest();
        $adapter->setNextRequestWillFail(true);

        $client = new HttpClient();
        $client->setUri('http://example.com/AuthSub');
        $client->setAdapter($adapter);

        $revoked = AuthSub::AuthSubRevokeToken($this->token, $client);
    }

    public function testGetAuthSubTokenInfoReceivesSuccessfulResult()
    {
        $adapter = new AdapterTest();
        $adapter->setResponse("HTTP/1.1 200 OK

Target=http://example.com
Scope=http://example.com
Secure=false");

        $client = new HttpClient();
        $client->setUri('http://example.com/AuthSub');
        $client->setAdapter($adapter);

        $respBody = AuthSub::getAuthSubTokenInfo($this->token, $client);

        $this->assertContains("Target=http://example.com", $respBody);
        $this->assertContains("Scope=http://example.com", $respBody);
        $this->assertContains("Secure=false", $respBody);
    }

    /**
     * @expectedException ZendGData\App\HttpException
     */
    public function testGetAuthSubTokenInfoCatchesHttpClientException()
    {
        $adapter = new AdapterTest();
        $adapter->setNextRequestWillFail(true);

        $client = new HttpClient();
        $client->setUri('http://example.com/AuthSub');
        $client->setAdapter($adapter);

        $revoked = AuthSub::getAuthSubTokenInfo($this->token, $client);
    }

    public function testGetHttpClientProvidesNewClientWhenNullPassed()
    {
        $client = AuthSub::getHttpClient($this->token);
        $this->assertTrue($client instanceof HttpClient );
        $this->assertEquals($this->token, $client->getAuthSubToken());
    }
}
