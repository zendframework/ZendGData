<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   ZendGData
 */

namespace ZendGDataTest\Calendar;

/**
 * @category   Zend
 * @package    ZendGData\Calendar
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Calendar
 */
class EventQueryExceptionTest extends \PHPUnit_Framework_TestCase
{

    const GOOGLE_DEVELOPER_CALENDAR = 'developer-calendar@google.com';

    public function setUp()
    {
        $this->query = new \ZendGData\Calendar\EventQuery();
    }

    public function testSingleEventsThrowsExceptionOnSetInvalidValue()
    {
        $this->query->resetParameters();
        $singleEvents = 'puppy';
        $this->setExpectedException('ZendGData\App\Exception');
        $this->query->setUser(self::GOOGLE_DEVELOPER_CALENDAR);
        $this->query->setSingleEvents($singleEvents);
    }

    public function testFutureEventsThrowsExceptionOnSetInvalidValue()
    {
        $this->query->resetParameters();
        $futureEvents = 'puppy';
        $this->setExpectedException('ZendGData\App\Exception');
        $this->query->setUser(self::GOOGLE_DEVELOPER_CALENDAR);
        $this->query->setFutureEvents($futureEvents);
    }

}
