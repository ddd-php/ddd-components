<?php

namespace Ddd\Time\Tests\HowTo;

use Ddd\Time\Tests\TestCase;
use Ddd\Time\Model\DateInterval;
use Ddd\Time\Model\Date;
use Ddd\Time\Model\TimeUnit;
use Ddd\Time\Model\Duration;
use Ddd\Time\Factory\TimeIntervalFactory;

class DateIntervalTest extends TestCase
{
    public function testHowToGetNumberOfDaysBetween2Dates()
    {
        $interval = new DateInterval(new Date(2013, 1, 1), new Date(2013, 1, 20));
        $duration = $interval->getDuration();

        $this->assertEquals(new Duration(19, TimeUnit::day()), $duration);
    }

    public function testHowToGetNumberOfHoursBetween2Dates()
    {
        $interval = new DateInterval(new Date(2013, 1, 1), new Date(2013, 1, 3));
        $duration = $interval->getDuration();

        $this->assertEquals(new Duration(48, TimeUnit::hour()), $duration->toHours()); // 2 days
    }

    public function testHowToGetNumberOfMinutesBetween2Dates()
    {
        $interval = new DateInterval(new Date(2013, 1, 1), new Date(2013, 1, 3));
        $duration = $interval->getDuration();

        $this->assertEquals(new Duration(60*24*2, TimeUnit::minute()), $duration->toMinutes()); // 2 days
    }

    public function testHowToGetNumberOfSecondsBetween2Dates()
    {
        $interval = new DateInterval(new Date(2013, 1, 1), new Date(2013, 1, 2));
        $duration = $interval->getDuration();

        $this->assertEquals(new Duration(60*60*24, TimeUnit::second()), $duration->toSeconds()); // 1 day
    }

    public function testHowToGetEachDayBetween2Dates()
    {
        $interval = new DateInterval(new Date(2013, 1, 1), new Date(2013, 1, 2));
        $duration = $interval->getDuration();
        $dates = array();
        do {
            $nextDate = $interval->getCurrent();
            $dates[] = $nextDate;
        } while ($interval->nextDate());

        $this->assertEquals(array(new Date(2013, 1, 1), new Date(2013, 1, 2)), $dates);
    }

    public function testHowToKnowIfADateIntervalIsBeforeAfterDuringOtherDateInterval()
    {
        $interval = new DateInterval(new Date(2013, 6, 1), new Date(2013, 6, 15));
        $before = new DateInterval(new Date(2013, 5, 20), new Date(2013, 5, 30));
        $after = new DateInterval(new Date(2013, 6, 16), new Date(2013, 6, 20));
        $during = new DateInterval(new Date(2013, 5, 1), new Date(2013, 6, 30));
        $partiallyDuring = new DateInterval(new Date(2013, 1, 1), new Date(2013, 6, 10));

        $this->assertTrue($interval->isBefore($after));
        $this->assertTrue($interval->isAfter($before));
        $this->assertTrue($interval->isDuring($during));
        $this->assertFalse($interval->isDuring($partiallyDuring));
    }

    public function testHowToKnowIfADateIntervalIsBeforeAfterDuringAGivenDate()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowIfADateIntervalIsBeforeAfterDuringAGivenTimeInterval()
    {
        $jan10to20   = new DateInterval(new Date(2013, 1, 10), new Date(2013, 1, 20));
        $timeInterval = TimeIntervalFactory::create('2013-01-01 10:00', '2013-01-21 20:00');

        $this->assertFalse($jan10to20->isBefore($timeInterval));
        $this->assertTrue($jan10to20->isDuring($timeInterval));
        $this->assertFalse($jan10to20->isAfter($timeInterval));
    }

    public function testHowToKnowIfADateIntervalIsBeforeAfterDuringAGivenTimePoint()
    {
        $this->markTestIncomplete();
    }

    public function testHowToTranformDateIntervalIntoTimeInterval()
    {
        $this->markTestIncomplete();
    }
}
