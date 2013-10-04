<?php

namespace Ddd\Time\Tests\HowTo;

use Ddd\Time\Tests\TestCase;
use Ddd\Time\Model\Duration;
use Ddd\Time\model\TimeUnit;

class DurationTest extends TestCase
{
    public function testHowToKnowHowLongXDaysInHoursMinutesSeconds()
    {
        $duration1 = new Duration(11, TimeUnit::day());
        $duration2 = new Duration(3, TimeUnit::day());
        $this->assertEquals(new Duration(15840, TimeUnit::minute()), $duration1->toMinutes());
        $this->assertEquals(new Duration(950400, TimeUnit::second()), $duration1->toSeconds());
        $this->assertEquals(new Duration(72, TimeUnit::hour()), $duration2->toHours());
        $this->assertEquals(new Duration(4320, TimeUnit::minute()), $duration2->toMinutes());
        $this->assertEquals(new Duration(259200, TimeUnit::second()), $duration2->toSeconds());
    }

    public function testHowToKnowHowLongXWeeksInDaysHoursMinutesSeconds()
    {
        $duration1 = new Duration(1, TimeUnit::week());
        $this->assertEquals(new Duration(7, TimeUnit::day()), $duration1->toDays());
        $this->assertEquals(new Duration(7*24, TimeUnit::hour()), $duration1->toHours());
        $this->assertEquals(new Duration(7*24*60, TimeUnit::minute()), $duration1->toMinutes());
        $this->assertEquals(new Duration(7*24*60*60, TimeUnit::second()), $duration1->toSeconds());
    }

    public function testHowToKnowHowLongXMonthsInWeeksDaysHoursMinutesSeconds()
    {
        $duration1 = new Duration(2, TimeUnit::month(), 2013, 2);
        $duration2 = new Duration(2, TimeUnit::month(), 2012, 2);

        $this->assertEquals(new Duration(28+31, TimeUnit::day()), $duration1->toDays());
        $this->assertEquals(new Duration(29+31, TimeUnit::day()), $duration2->toDays());
        $this->assertEquals(new Duration((28+31)*24, TimeUnit::hour()), $duration1->toHours());
        $this->assertEquals(new Duration((28+31)*24*60, TimeUnit::minute()), $duration1->toMinutes());
        $this->assertEquals(new Duration((28+31)*24*60*60, TimeUnit::second()), $duration1->toSeconds());
    }

    public function testHowToKnowHowLongXYearsInMonthsWeeksDaysHoursMinutesSeconds()
    {
        $duration1 = new Duration(1, TimeUnit::year(), 2013);
        $duration2 = new Duration(1, TimeUnit::year(), 2012);

        $this->assertEquals(new Duration(365, TimeUnit::day()), $duration1->toDays());
        $this->assertEquals(new Duration(366, TimeUnit::day()), $duration2->toDays());
        $this->assertEquals(new Duration(365*24, TimeUnit::hour()), $duration1->toHours());
        $this->assertEquals(new Duration(365*24*60, TimeUnit::minute()), $duration1->toMinutes());
        $this->assertEquals(new Duration(365*24*60*60, TimeUnit::second()), $duration1->toSeconds());
    }

    public function testHowToKnowHowLongAYearsBMonthsCWeeksDDaysInHoursMinutesSeconds()
    {
        $this->markTestIncomplete();
    }
}
