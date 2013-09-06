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
        $this->markTestIncomplete();
    }

    public function testHowToKnowHowLongXMonthsInWeeksDaysHoursMinutesSeconds()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowHowLongXYearsInMonthsWeeksDaysHoursMinutesSeconds()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowHowLongXCenturiesInYearsMonthsWeeksDaysHoursMinutesSeconds()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowHowLongAYearsBMonthsCWeeksDDaysInHoursMinutesSeconds()
    {
        $this->markTestIncomplete();
    }
}
