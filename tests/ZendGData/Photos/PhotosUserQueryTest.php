<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Photos;

use ZendGData\Photos;
use ZendGData\App;

/**
 * @category   Zend
 * @package    ZendGData\Photos
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Photos
 */
class PhotosUserQueryTest extends \PHPUnit_Framework_TestCase
{

    /**
      * Check the consistency of a user feed request
      */
    public function testSimpleUserQuery()
    {
        $queryString = "https://picasaweb.google.com/data/feed/api/user/sample.user";

        $query = new Photos\UserQuery();
        $query->setUser("sample.user");

        $generatedString = $query->getQueryUrl();

        // Assert that the generated query matches the correct one
        $this->assertEquals($queryString, $generatedString);
    }

    /**
      * Check the consistency of a user feed request
      * Projection is set to base
      */
    public function testBaseUserQuery()
    {
        $queryString = "https://picasaweb.google.com/data/feed/base/user/sample.user";

        $query = new Photos\UserQuery();
        $query->setUser("sample.user");
        $query->setProjection("base");

        $generatedString = $query->getQueryUrl();

        // Assert that the generated query matches the correct one
        $this->assertEquals($queryString, $generatedString);
    }

    /**
      * Check for thrown exceptions upon improper albumname/id setting
      */
    public function testUserQueryExceptions()
      {
        $query = new Photos\UserQuery();
        $query->setUser("sample.user");
        $query->setProjection(null);

        try {
            $generatedString = $query->getQueryUrl();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof App\InvalidArgumentException);
        }

        $query->setProjection("api");
        $query->setUser(null);

        try {
            $generatedString = $query->getQueryUrl();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof App\InvalidArgumentException);
        }
      }

    /**
      * Check the consistency of a user feed request filtered
      * for a specific tag
      */
    public function testTagFilterUserQuery()
    {
        $queryString = "https://picasaweb.google.com/data/feed/api/user/sample.user?tag=test";

        $query = new Photos\UserQuery();
        $query->setUser("sample.user");
        $query->setTag("test");

        $generatedString = $query->getQueryUrl();

        // Assert that the generated query matches the correct one
        $this->assertEquals($queryString, $generatedString);
    }

    /**
      * Check the consistency of a user feed request for private data
      */
    public function testPrivateUserQuery()
    {
        $queryString = "https://picasaweb.google.com/data/feed/api/user/sample.user?access=private";

        $query = new Photos\UserQuery();
        $query->setUser("sample.user");
        $query->setAccess("private");

        $generatedString = $query->getQueryUrl();

        // Assert that the generated query matches the correct one
        $this->assertEquals($queryString, $generatedString);
    }

}
