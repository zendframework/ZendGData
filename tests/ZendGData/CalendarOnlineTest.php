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

use ZendGData\Calendar;

/**
 * @category   Zend
 * @package    ZendGData\Calendar
 * @subpackage UnitTests
 * @group      ZendGData
 * @group      ZendGData\Calendar
 */
class CalendarOnlineTest extends \PHPUnit_Framework_TestCase
{

    const GOOGLE_DEVELOPER_CALENDAR = 'developer-calendar@google.com';
    const ZEND_CONFERENCE_EVENT = 'bn2h4o4mc3a03ci4t48j3m56pg';

    public function setUp()
    {
        if (!constant('TESTS_ZEND_GDATA_ONLINE_ENABLED')) {
            $this->markTestSkipped('ZendGData online tests are not enabled');
        }
        $user = constant('TESTS_ZEND_GDATA_CLIENTLOGIN_EMAIL');
        $pass = constant('TESTS_ZEND_GDATA_CLIENTLOGIN_PASSWORD');
        $service = Calendar::AUTH_SERVICE_NAME;
        $client = \ZendGData\ClientLogin::getHttpClient($user, $pass, $service);
        $this->gdata = new Calendar($client);
    }

    public function testCalendarListFeed()
    {
        $calFeed = $this->gdata->getCalendarListFeed();
        $this->assertTrue(strpos($calFeed->title->text, 'Calendar List')
                !== false);
        $calCount = 0;
        foreach ($calFeed as $calendar) {
            $calCount++;
        }
        $this->assertTrue($calCount > 0);
    }

    /**
     * @group ZF-1701
     */
    public function testCalendarOnlineFeed()
    {
        $eventFeed = $this->gdata->getCalendarEventFeed();
        $this->assertTrue(strpos($eventFeed->title->text, TESTS_ZEND_GDATA_CLIENTLOGIN_EMAIL)
            !== false);
        $eventCount = 0;
        foreach ( $eventFeed as $event ) {
            $this->assertInstanceOf('ZendGData\Calendar\EventEntry', $event);
            $eventCount++;
        }
        $this->assertTrue($eventCount > 0 );
        $this->assertTrue(count($eventFeed) == $eventCount);
    }

    public function getEvent($eventId)
    {
        $query = $this->gdata->newEventQuery();
        $query->setUser('default');
        $query->setVisibility('private');
        $query->setProjection('full');
        $query->setEvent($eventId);

        $eventEntry = $this->gdata->getCalendarEventEntry($query);
        $this->assertTrue(
                $eventEntry instanceof Calendar\EventEntry);
        return $eventEntry;
    }

    public function createEvent(
            $title = 'Tennis with Beth',
            $desc='Meet for a quick lesson', $where = 'On the courts',
            $startDate = '2008-01-20', $startTime = '10:00',
            $endDate = '2008-01-20', $endTime = '11:00', $tzOffset = '-08')
    {
        $newEntry = $this->gdata->newEventEntry();
        $newEntry->title = $this->gdata->newTitle(trim($title));
        $newEntry->where  = array($this->gdata->newWhere($where));

        $newEntry->content = $this->gdata->newContent($desc);
        $newEntry->content->type = 'text';

        $when = $this->gdata->newWhen();
        $when->startTime = "{$startDate}T{$startTime}:00.000{$tzOffset}:00";
        $when->endTime = "{$endDate}T{$endTime}:00.000{$tzOffset}:00";
        $reminder = $this->gdata->newReminder();
        $reminder->minutes = '30';
        $reminder->method = 'email';
        $when->reminders = array($reminder);
        $newEntry->when = array($when);

        $createdEntry = $this->gdata->insertEvent($newEntry);

        $this->assertEquals('email in 30 minutes', $reminder->__toString());
        $this->assertEquals($title, $createdEntry->title->text);
        $this->assertEquals($desc, $createdEntry->content->text);
        $this->assertEquals(strtotime($when->startTime),
                strtotime($createdEntry->when[0]->startTime));
        $this->assertEquals(strtotime($when->endTime),
                strtotime($createdEntry->when[0]->endTime));
        $this->assertEquals($reminder->method,
                $createdEntry->when[0]->reminders[0]->method);
        $this->assertEquals($reminder->minutes,
                $createdEntry->when[0]->reminders[0]->minutes);
        $this->assertEquals($where, $createdEntry->where[0]->valueString);

        return $createdEntry;
    }

    public function updateEvent ($eventId, $newTitle)
    {
        $eventOld = $this->getEvent($eventId);
        $eventOld->title = $this->gdata->newTitle($newTitle);
        $eventOld->save();
        $eventNew = $this->getEvent($eventId);
        $this->assertEquals($newTitle, $eventNew->title->text);
        return $eventNew;
    }

    public function testCreateEvent()
    {
        $createdEntry = $this->createEvent();
    }

    public function testCreateAndUpdateEvent()
    {
        $newTitle = 'my new title';
        $createdEntry = $this->createEvent();
        preg_match('#.*/([A-Za-z0-9]+)$#', $createdEntry->id->text, $matches);
        $id = $matches[1];
        $updatedEvent = $this->updateEvent($id, $newTitle);
        $this->assertEquals($newTitle, $updatedEvent->title->text);
    }

    public function testCreateAndDeleteEvent()
    {
        /* deletion can be performed in several different ways-- test all */
        $createdEntry = $this->createEvent();
        $createdEntry->delete();

        $createdEntry2 = $this->createEvent();
        $this->gdata->delete($createdEntry2);

        $createdEntry3 = $this->createEvent();
        $this->gdata->delete($createdEntry3->getEditLink()->href);
    }
}
