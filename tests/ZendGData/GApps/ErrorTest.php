<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\GApps;

use ZendGData\GApps;

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class ErrorTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->error = new GApps\Error();
    }

    public function testCanSetAndGetErrorCodeUsingConstant()
    {
        $this->error->setErrorCode(
            GApps\Error::INVALID_EMAIL_ADDRESS);
        $this->assertEquals(GApps\Error::INVALID_EMAIL_ADDRESS,
            $this->error->getErrorCode());
    }

    public function testCanSetAndGetErrorCodeUsingInteger()
    {
        $this->error->setErrorCode(123);
        $this->assertEquals(123, $this->error->getErrorCode());
    }

   public function testCanSetAndGetReason()
   {
        $text = "The foo is missing a bar.";
        $this->error->setReason($text);
        $this->assertEquals($text, $this->error->getReason());
    }

    public function testCanSetAndGetInvalidInput()
    {
         $text = "for___baz";
         $this->error->setInvalidInput($text);
         $this->assertEquals($text, $this->error->getInvalidInput());
    }

    public function testContstructorAllowsSettingAllVariables()
    {
        $this->error = new GApps\Error(
            GApps\Error::USER_DELETED_RECENTLY,
            "foo", "bar");
        $this->assertEquals(GApps\Error::USER_DELETED_RECENTLY,
            $this->error->getErrorCode());
        $this->assertEquals("foo", $this->error->getReason());
        $this->assertEquals("bar", $this->error->getInvalidInput());
    }

    public function testToStringProvidesHelpfulMessage()
    {
        $this->error->setErrorCode(GApps\Error::USER_SUSPENDED);
        $this->error->setReason("The foo is missing a bar.");
        $this->error->setInvalidInput("for___baz");
        $this->assertEquals("Error 1101: The foo is missing a bar.\n\tInvalid Input: \"for___baz\"", $this->error->__toString());

        $this->error->setErrorCode(GApps\Error::UNKNOWN_ERROR);
        $this->error->setReason("Unknown error.");
        $this->error->setInvalidInput("blah");
        $this->assertEquals("Error 1000: Unknown error.\n\tInvalid Input: \"blah\"", $this->error->__toString());
    }

}
