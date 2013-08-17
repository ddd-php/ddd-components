<?php

namespace Ddd\Time\Tests\HowTo;

use Ddd\Time\Model\Duration;
use Ddd\Time\Model\TimePoint;
use Ddd\Time\Model\TimeUnit;
use Ddd\Time\Tests\TestCase;
use Ddd\Time\Model\Date;
use Ddd\Time\Factory\DateIntervalFactory;

class DateTest extends TestCase
{
    public function testHowToCreateADateOnly()
    {
        $date = new Date(2013, 1, 1);

        $this->assertInstanceOf('Ddd\Time\Model\Date', $date);
    }

    public function testHowToComeBackAtBeginOfCurrentWeek()
    {
        $friday = new Date(2013, 1, 4);
        $monday = $friday->beginOfWeek();

        $this->assertEquals(new Date(2012, 12, 31), $monday);
    }

    public function testHowToKnowIfADateIsAfterBeforeEqualToAnOther()
    {
        $jan1 = new Date(2013, 1, 1);

        $this->assertTrue($jan1->isBefore(new Date(2013, 1, 2)));
        $this->assertTrue($jan1->isAfter(new Date(2012, 12, 31)));
        $this->assertTrue($jan1->isEquals($jan1));
    }

    /**
     * Usecases:
     * - I want to display a date in custom format in templates.
     *
     */
    public function testHowToConvertADddTimeDateObjectIntoRegularDateTimeObject()
    {
        $jan1 = new Date(2013, 1, 1);

        $this->assertEquals(new \DateTime('2013-01-01 00:00:00'), $jan1->toDateTime());
    }

    public function testHowToKnowIfDateIsDuringWeekendOrWeekday()
    {
        $tuesday = new Date(2013, 1, 1);
        $saturday = $tuesday->plus(new Duration(4, TimeUnit::day()));

        $this->assertFalse($tuesday->isWeekEndDay());
        $this->assertTrue($tuesday->isWeekDay());
        $this->assertTrue($saturday->isWeekEndDay());
        $this->assertFalse($saturday->isWeekDay());
    }

    public function testHowToGetPreviousNextDate()
    {
        $jan1   = new Date(2013, 1, 1);
        $dec31  = $jan1->previous();
        $jan2   = $jan1->next();

        $this->assertEquals(new Date(2012, 12, 31), $dec31);
        $this->assertEquals(new Date(2013, 1, 2), $jan2);
    }

    public function testHowToAddRemoveADurationFromItInDays()
    {
        $jan1   = new Date(2013, 1, 1);
        $dec31 = $jan1->minus(new Duration(1, TimeUnit::day()));
        $jan3  = $jan1->plus(new Duration(2, TimeUnit::day()));

        $this->assertEquals(new Date(2012, 12, 31), $dec31);
        $this->assertEquals(new Date(2013, 1, 3), $jan3);
    }

    public function testHowToAddRemoveADurationFromItInYearsMonthsWeeks()
    {
        $this->markTestIncomplete();
    }

    public function testHowToAddRemoveADurationFromItInHoursMinutesSeconds()
    {
        $this->markTestIncomplete();
    }

    /**
     * eg. Allow to add/remove 2 days, 5 hours and 42 minutes easily.
     */
    public function testHowToAddRemoveACompositeDuration()
    {
    }

    public function testHowToTransformADateIntoATimePoint()
    {
        $jan1   = new Date(2013, 1, 1);
        $timePoint = $jan1->toTimePoint();

        $this->assertInstanceOf('Ddd\Time\Model\TimePoint', $timePoint);
        $this->assertEquals($timePoint->getYear(), 2013);
        $this->assertEquals($timePoint->getMonth(), 1);
        $this->assertEquals($timePoint->getDay(), 1);
        $this->assertEquals($timePoint->getHour(), 0);
        $this->assertEquals($timePoint->getMinutes(), 0);
        $this->assertEquals($timePoint->getSeconds(), 0);
    }

    /**
     * Use cases :
     *  - Calculate difference between 2 days
     *  - Fetch the position of a date from another
     *  - How many days form my birthday
     *
     * Returns a Duration Class @see Ddd\Time\Model\Duration.
     *
     */
    public function testHowToKnowDiffBetweenItAndAnOtherDate()
    {
        $jan1 = new Date(2013, 1, 1);
        $jan10 = new Date(2013, 1, 10);
        $diff = $jan1->diff($jan10);

        $this->assertInstanceOf('Ddd\Time\Model\Duration', $diff);
        $this->assertEquals($diff, new Duration(9, TimeUnit::day()));
    }

    public function testHowToKnowDiffBetweenItAndATimePoint()
    {
        $this->markTestIncomplete('Should return a composite duration');
    }

    public function testHowToKnowIfDateIsBeforeDuringAfterADateInterval()
    {
        $winterHolidays2013 = DateIntervalFactory::create('2012-12-20', '2013-01-05');
        $dadVisit = new Date(2012, 12, 29);
        $dadVisit = $dadVisit->toDateInterval();

        $this->assertTrue($dadVisit->isDuring($winterHolidays2013));
        $this->assertFalse($dadVisit->isBefore($winterHolidays2013));
        $this->assertFalse($dadVisit->isAfter($winterHolidays2013));
    }
}
