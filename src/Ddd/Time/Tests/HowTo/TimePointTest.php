<?php

namespace Ddd\Time\Tests\HowTo;

use Ddd\Time\Tests\TestCase;
use Ddd\Time\Model\TimePoint;
use Ddd\Time\Model\Duration;
use Ddd\Time\Model\TimeUnit;
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
        $timepoint = new TimePoint(2013, 3, 12, 18, 27);
        $datebefore = new Date(2013, 1, 1);
        $dateafter = new Date(2013, 8, 15);
        $dateequal = new Date(2013, 3, 12);
        $this->assertEquals(true, $datebefore->isBefore($timepoint->getDate()));
        $this->assertEquals(true, $dateafter->isAfter($timepoint->getDate()));
        $this->assertEquals(true, $dateequal->isEquals($timepoint->getDate()));
    }

    public function testHowToKnowIfItIsBeforeAfterDuringAGivenDateInterval()
    {
        
    }

    public function testHowToKnowIfAItIsBbeforeAfterEqualAGivenTimeInterval()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowIfItIsDuringNightOrDaylight()
    {
        $this->markTestIncomplete();
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
