<?php

namespace Ddd\Time\Tests\HowTo;

use Ddd\Time\Model\TimeInterval;
use Ddd\Time\Tests\TestCase;
use Ddd\Time\Model\TimePoint;
use Ddd\Time\Model\Duration;
use Ddd\Time\Model\TimeUnit;
use Ddd\Time\Model\DateInterval;
use Ddd\Time\Model\Date;
use Ddd\Time\Factory\DateIntervalFactory;
use Ddd\Time\Factory\TimeIntervalFactory;

class TimePointTest extends TestCase
{
    public function testHowToKnowIfItIsBeforeAfterEqualAnOtherTimePoint()
    {
        $first = new TimePoint(2013, 3, 12, 18, 27);
        $second = new TimePoint(2013, 6, 23, 6, 31, 11);
        $third = new TimePoint(2013, 6, 23, 6, 31, 11);

        $this->assertEquals($second->isAfter($first), true);
        $this->assertEquals($second->isBefore($third), false);
        $this->assertEquals($first->isAfter($second), false);
        $this->assertEquals($third->isEquals($second), true);
    }

    public function testHowToKnowIfItIsBeforeAfterEqualAGivenDate()
    {
        $timePoint = new TimePoint(2013, 3, 12, 18, 27);
        $dateBefore = new Date(2013, 1, 1);
        $dateAfter = new Date(2013, 8, 15);
        $dateEqual = new Date(2013, 3, 12);
        $this->assertEquals(true, $dateBefore->isBefore($timePoint->getDate()));
        $this->assertEquals(true, $dateAfter->isAfter($timePoint->getDate()));
        $this->assertEquals(true, $dateEqual->isEquals($timePoint->getDate()));
    }

    public function testHowToKnowIfItIsBeforeAfterDuringAGivenDateInterval()
    {
        $timePoint = new TimePoint(2013, 3, 1, 18, 27);
        $dateInterval = new DateInterval(new Date(2013, 1, 1), new Date(2013, 1, 15));

        $this->assertEquals(true, $dateInterval->isBefore($timePoint->getDate()->toDateInterval()));
        $this->assertEquals(false, $dateInterval->isAfter($timePoint->getDate()->toDateInterval()));
        $this->assertEquals(false, $dateInterval->isDuring($timePoint->getDate()->toDateInterval()));
    }

    public function testHowToKnowIfItIsBeforeAfterEqualsAGivenTimeInterval()
    {
        $timePoint = new TimePoint(2013, 3, 1, 18, 27);
        $timeInterval = new TimeInterval(new TimePoint(2013, 1, 1, 0, 30), new TimePoint(2013, 1, 15, 23, 30));

        $this->assertEquals(true, $timeInterval->isBefore($timePoint->toTimeInterval()));
        $this->assertEquals(false, $timeInterval->isAfter($timePoint->toTimeInterval()));
        $this->assertEquals(false, $timeInterval->isDuring($timePoint->toTimeInterval()));
    }

    public function testHowToKnowIfItIsDuringNightOrDaylight()
    {
        $nightTimePoint = new TimePoint(2013, 3, 12, 3, 30);
        $dayTimePoint = new TimePoint(2013, 3, 12, 15, 30);

        // Using the Eiffel Tower's coordinates
        $this->assertTrue($nightTimePoint->isNightTime(48.8582, 2.2945));
        $this->assertFalse($dayTimePoint->isNightTime(48.8582, 2.2945));
    }

    public function testHowToAddRemoveDurationFromIt()
    {
        $startTimePoint = new TimePoint(2013, 3, 12, 18, 27);
        $stopTimePoint = new TimePoint(2013, 3, 14, 18, 27);
        $duration = new Duration(2, TimeUnit::day());
        $result = $startTimePoint->plus($duration);
        $this->assertEquals($result, $stopTimePoint);
    }

    public function testHowToConvertADddTimePointObjectIntoRegularDateTimeobject()
    {
        $timepoint = new TimePoint(2013, 3, 12, 18, 27, 11);
        $datetime = new \DateTime();
        $datetime->setDate(2013, 3, 12);
        $datetime->setTime(18, 27, 11);
        $this->assertEquals($timepoint->toDateTime(), $datetime);
    }

    public function testHowToKnowIfTimePointIsBeforeDuringAfterATimeInterval()
    {
        $doctorAppointment = new TimePoint(2013, 1, 5, 10, 0);
        $doctorAppointment = $doctorAppointment->toTimeInterval();
        $samBrithdayParty = TimeIntervalFactory::create('2013-01-05 11:30', '2013-01-05 13:00');
        $sportSession = TimeIntervalFactory::create('2013-01-05 09:00', '2013-01-05 10:30');

        $this->assertTrue($doctorAppointment->isBefore($samBrithdayParty));
        $this->assertTrue($doctorAppointment->isDuring($sportSession));
    }
}
