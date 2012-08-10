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

use ZendGData\App;

/**
 * @category   Zend
 * @package    ZendGData\App
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\App
 */
class CaptchaRequiredExceptionTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->exampleException = new App\CaptchaRequiredException('testtoken', 'Captcha?ctoken=testtoken');
    }

    public function testExceptionContainsValidInformation()
    {
        $this->assertEquals('testtoken', $this->exampleException->getCaptchaToken());
        $this->assertEquals('https://www.google.com/accounts/Captcha?ctoken=testtoken', $this->exampleException->getCaptchaUrl());
    }

    public function testExceptionIsThrowable()
    {
        $caught = false;
        try {
            throw $this->exampleException;
        } catch(App\CaptchaRequiredException $e) {
            $caught = true;
        }

        $this->assertTrue($caught);
    }

}
