<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Analytics;

use ZendGData\Analytics\AccountFeed;

/**
 * @category   Zend
 * @package    ZendGData\Analytics
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData_Analytics
 */
class AccountFeedTest extends \PHPUnit_Framework_TestCase
{

    /** @var AccountFeed */
    public $accountFeed;

    public function setUp()
    {
        $this->accountFeed = new AccountFeed(
            file_get_contents(dirname(__FILE__) . '/_files/TestAccountFeed.xml')
        );
    }

    public function testAccountFeed()
    {
        $this->assertEquals(2, count($this->accountFeed->entries));

        foreach ($this->accountFeed->entries as $entry) {
            $this->assertInstanceOf('ZendGData\Analytics\AccountEntry', $entry);
        }
    }
    
    public function testFirstAccountProperties()
    {
        $account = $this->accountFeed->entries[0];
        $this->assertEquals(876543, "{$account->accountId}");
        $this->assertEquals('foobarbaz', "{$account->accountName}");
        $this->assertInstanceOf('ZendGData\App\Extension\Link', $account->link[0]);
    }
    
    public function testSecondAccountProperties()
    {
        $account = $this->accountFeed->entries[1];
        $this->assertEquals(23456789, "{$account->accountId}");
        $this->assertEquals('brain dump', "{$account->accountName}");
        $this->assertInstanceOf('ZendGData\App\Extension\Link', $account->link[0]);
    }
}
