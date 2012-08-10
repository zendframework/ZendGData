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

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class EmailListQueryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->query = new \ZendGData\GApps\EmailListQuery();
    }

    // Test to make sure that URI generation works
    public function testDefaultQueryURIGeneration()
    {
        $this->query->setDomain("foo.bar.invalid");
        $this->assertEquals("https://apps-apis.google.com/a/feeds/foo.bar.invalid/emailList/2.0",
                $this->query->getQueryUrl());
    }

    // Test to make sure that the domain accessor methods work and propagate
    // to the query URI.
    public function testCanSetQueryDomain()
    {
        $this->query->setDomain("my.domain.com");
        $this->assertEquals("my.domain.com", $this->query->getDomain());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0",
                $this->query->getQueryUrl());

        $this->query->setDomain("hello.world.baz");
        $this->assertEquals("hello.world.baz", $this->query->getDomain());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/hello.world.baz/emailList/2.0",
                $this->query->getQueryUrl());
    }

    // Test to make sure that the emailListName accessor methods work and propagate
    // to the query URI.
    public function testCanSetEmailListNameProperty()
    {
        $this->query->setDomain("my.domain.com");
        $this->query->setEmailListName("foo");
        $this->assertEquals("foo", $this->query->getEmailListName());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0/foo",
                $this->query->getQueryUrl());

        $this->query->setEmailListName("bar");
        $this->assertEquals("bar", $this->query->getEmailListName());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0/bar",
                $this->query->getQueryUrl());
    }

    // Test to make sure that the recipient accessor methods work and propagate
    // to the query URI.
    public function testCanSetRecipientProperty()
    {
        $this->query->setDomain("my.domain.com");
        $this->query->setRecipient("bar@qux.com");
        $this->assertEquals("bar@qux.com", $this->query->getRecipient());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0?recipient=bar%40qux.com",
                $this->query->getQueryUrl());

        $this->query->setRecipient(null);
        $this->assertEquals(null, $this->query->getRecipient());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0",
                $this->query->getQueryUrl());
    }

    // Test to make sure that the startUsername accessor methods work and
    // propagate to the query URI.
    public function testCanSetStartEmailListNameProperty()
    {
        $this->query->setDomain("my.domain.com");
        $this->query->setStartEmailListName("foo");
        $this->assertEquals("foo", $this->query->getStartEmailListName());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0?startEmailListName=foo",
                $this->query->getQueryUrl());

        $this->query->setStartEmailListName(null);
        $this->assertEquals(null, $this->query->getStartEmailListName());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0",
                $this->query->getQueryUrl());
    }

    // Test to make sure that all parameters can be set simultaneously with no
    // ill effects.
    public function testCanSetAllParameters()
    {
        $this->query->setDomain("my.domain.com");
        $this->query->setEmailListName("foo");
        $this->query->setRecipient("bar@qux.com");
        $this->query->setStartEmailListName("wibble");
        $this->assertEquals("foo", $this->query->getEmailListName());
        $this->assertEquals("bar@qux.com", $this->query->getRecipient());
        $this->assertEquals("wibble", $this->query->getStartEmailListName());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0/foo?recipient=bar%40qux.com&startEmailListName=wibble",
                $this->query->getQueryUrl());

        $this->query->setRecipient("baz@blah.com");
        $this->query->setEmailListName("xyzzy");
        $this->query->setStartEmailListName("woof");
        $this->assertEquals("xyzzy", $this->query->getEmailListName());
        $this->assertEquals("baz@blah.com", $this->query->getRecipient());
        $this->assertEquals("woof", $this->query->getStartEmailListName());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/my.domain.com/emailList/2.0/xyzzy?recipient=baz%40blah.com&startEmailListName=woof",
                $this->query->getQueryUrl());
    }

}
