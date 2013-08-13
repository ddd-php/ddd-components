<?php

namespace Ddd\Calendar\Tests\Howto;

use Ddd\Calendar\Tests\TestCase;
use Ddd\Calendar\Model\Calendar;
use Ddd\Calendar\Model\Event;
use Ddd\Time\Model\TimePoint;
use Ddd\Time\Factory\TimeIntervalFactory;
use Ddd\Time\Factory\DateIntervalFactory;

class CalendarTest extends TestCase
{
    private $calendar;

    public function setup()
    {
        $repository = new DoctorCalendarRepository();
        $this->calendar = $repository->load();
    }

    public function testHowToLoadEventsFromDatastore()
    {
        $this->markTestIncomplete();
    }

    public function testHowToRetrieveAllMyAppointments()
    {
        $this->assertSame('Doctor Smith\'s appointments', $this->calendar->getTitle());
        $this->assertCount(3, $this->calendar);
    }

    public function testHowToRetrieveMyAppointmentsForToday()
    {
        $today = DateIntervalFactory::create('2012-01-01', '2012-01-01');
        $this->assertCount(1, $this->calendar->between(TimeIntervalFactory::fromDateInterval($today)));
    }

    public function testHowToRetrieveAppointmentsAfterADate()
    {
        $today = new TimePoint(2012, 1, 1, 10, 0);
        $this->calendar->setCursor($today);
        $this->assertSame(2, $this->calendar->countRemaining());
    }

    public function testHowToRetrieveMyAppointmentsForCurrentWeek()
    {
        $week = DateIntervalFactory::create('2012-01-01', '2012-01-07');
        $this->assertCount(2, $this->calendar->between(TimeIntervalFactory::fromDateInterval($week)));
    }

    public function testHowToAddNewAppointment()
    {
        $event = new Event(TimeIntervalFactory::create('2012-01-01 17:00', '2012-01-01 18:00'));
        $this->calendar->add($event);
        $this->assertCount(4, $this->calendar);
    }
}

