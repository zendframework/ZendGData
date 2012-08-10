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

use ZendGData\GApps\MemberQuery;

/**
 * @category   Zend
 * @package    ZendGData\GApps
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\GApps
 */
class MemberQueryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->query = new MemberQuery();
    }

    // Test to make sure that the domain accessor methods work and propagate
    // to the query URI.
    public function testCanSetQueryDomain()
    {
        $this->query->setGroupId("something");
        $this->query->setDomain("my.domain.com");
        $this->assertEquals("my.domain.com", $this->query->getDomain());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/group/2.0/my.domain.com/something/member",
                $this->query->getQueryUrl());

        $this->query->setDomain("hello.world.baz");
        $this->assertEquals("hello.world.baz", $this->query->getDomain());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/group/2.0/hello.world.baz/something/member",
                $this->query->getQueryUrl());
    }

    // Test to make sure that the groupId accessor methods work and propagate
    // to the query URI.
    public function testCanSetGroupIdProperty()
    {
        $this->query->setDomain("my.domain.com");
        $this->query->setGroupId("foo");
        $this->assertEquals("foo", $this->query->getGroupId());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/group/2.0/my.domain.com/foo/member",
                $this->query->getQueryUrl());

        $this->query->setGroupId("bar");
        $this->assertEquals("bar", $this->query->getGroupId());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/group/2.0/my.domain.com/bar/member",
                $this->query->getQueryUrl());
    }

    // Test to make sure that the memberId accessor methods work and propagate
    // to the query URI.
    public function testCanSetMemberIdProperty()
    {
        $this->query->setDomain("my.domain.com");
        $this->query->setGroupId("foo");
        $this->query->setMemberId("bar");
        $this->assertEquals("bar", $this->query->getMemberId());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/group/2.0/my.domain.com/foo/member/bar",
                $this->query->getQueryUrl());

        $this->query->setGroupId("baz");
        $this->query->setMemberId(null);
        $this->assertEquals(null, $this->query->getMemberId());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/group/2.0/my.domain.com/baz/member",
                $this->query->getQueryUrl());
    }

    public function testCanSetStartMemberIdProperty()
    {
        $this->query->setDomain("my.domain.com");
        $this->query->setGroupId("foo");
        $this->query->setStartMemberId("bar");
        $this->assertEquals("bar", $this->query->getStartMemberId());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/group/2.0/my.domain.com/foo/member?start=bar",
                $this->query->getQueryUrl());

        $this->query->setStartMemberId(null);
        $this->assertEquals(null, $this->query->getStartMemberId());
        $this->assertEquals("https://apps-apis.google.com/a/feeds/group/2.0/my.domain.com/foo/member",
                $this->query->getQueryUrl());
    }

}

