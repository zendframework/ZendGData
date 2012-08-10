<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Docs;

/**
 * @category   Zend
 * @package    ZendGData\Docs
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Docs
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->docQuery = new \ZendGData\Docs\Query();
    }

    public function testTitle()
    {
        $this->assertTrue($this->docQuery->getTitle() == null);
        $this->docQuery->setTitle('test title');
        $this->assertTrue($this->docQuery->getTitle() == 'test title');
        $this->assertTrue($this->docQuery->getQueryString() == '?title=test+title');
        $this->docQuery->setTitle(null);
        $this->assertTrue($this->docQuery->getTitle() == null);
    }

    public function testTitleExact()
    {
        $this->assertTrue($this->docQuery->getTitleExact() == null);
        $this->docQuery->setTitleExact('test title');
        $this->assertTrue($this->docQuery->getTitleExact() == 'test title');
        $this->assertTrue($this->docQuery->getQueryString() == '?title-exact=test+title');
        $this->docQuery->setTitleExact(null);
        $this->assertTrue($this->docQuery->getTitleExact() == null);
    }

    public function testProjection()
    {
        $this->assertTrue($this->docQuery->getProjection() == 'full');
        $this->docQuery->setProjection('abc');
        $this->assertTrue($this->docQuery->getProjection() == 'abc');
    }

    public function testVisibility()
    {
        $this->assertTrue($this->docQuery->getVisibility() == 'private');
        $this->docQuery->setVisibility('xyz');
        $this->assertTrue($this->docQuery->getVisibility() == 'xyz');
    }
}
