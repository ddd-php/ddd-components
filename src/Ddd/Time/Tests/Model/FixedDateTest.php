<?php

namespace Ddd\Time\Tests\Model;

use Ddd\Time\Model\FixedDate;
use Ddd\Time\Model\Date;
use Ddd\Time\Tests\TestCase;

class FixedDateTest extends TestCase
{
    public function testIsAfter()
    {
        $christmasDay = new FixedDate(12, 25);
        $this->assertFalse($christmasDay->isAfter(new Date(2013, 12, 25)));
        $this->assertFalse($christmasDay->isAfter(new Date(2000, 12, 25)));
        $this->assertTrue($christmasDay->isAfter(new Date(2013, 12, 24)));
        $this->assertTrue($christmasDay->isAfter(new Date(2000, 12, 24)));
        $this->assertFalse($christmasDay->isAfter(new Date(2013, 12, 26)));
        $this->assertFalse($christmasDay->isAfter(new Date(2000, 12, 26)));
    }

    public function testIsAfterWhenMonthNotGiven()
    {
        $day25 = new FixedDate(null, 25);
        $this->assertTrue($day25->isAfter(new Date(2013, 12, 24)));
        $this->assertTrue($day25->isAfter(new Date(2013, 1, 24)));
        $this->assertTrue($day25->isAfter(new Date(2000, 5, 24)));
    }

    public function testIsBefore()
    {
        $christmasDay = new FixedDate(12, 25);
        $this->assertFalse($christmasDay->isBefore(new Date(2013, 12, 25)));
        $this->assertFalse($christmasDay->isBefore(new Date(2000, 12, 25)));
        $this->assertFalse($christmasDay->isBefore(new Date(2013, 12, 24)));
        $this->assertFalse($christmasDay->isBefore(new Date(2000, 12, 24)));
        $this->assertTrue($christmasDay->isBefore(new Date(2013, 12, 26)));
        $this->assertTrue($christmasDay->isBefore(new Date(2000, 12, 26)));
    }

    public function testIsBeforeWhenMonthNotGiven()
    {
        $day25 = new FixedDate(null, 25);
        $this->assertTrue($day25->isBefore(new Date(2013, 12, 26)));
        $this->assertTrue($day25->isBefore(new Date(2013, 1, 26)));
        $this->assertTrue($day25->isBefore(new Date(2000, 5, 26)));
    }

    public function testIsEquals()
    {
        $christmasDay = new FixedDate(12, 25);
        $this->assertTrue($christmasDay->isEquals(new Date(2013, 12, 25)));
        $this->assertTrue($christmasDay->isEquals(new Date(2000, 12, 25)));
        $this->assertFalse($christmasDay->isEquals(new Date(2013, 12, 24)));
        $this->assertFalse($christmasDay->isEquals(new Date(2000, 12, 24)));
        $this->assertFalse($christmasDay->isEquals(new Date(2013, 12, 26)));
        $this->assertFalse($christmasDay->isEquals(new Date(2000, 12, 26)));
    }

    public function testIsEqualsWhenMonthNotGiven()
    {
        $day25 = new FixedDate(null, 25);
        $this->assertTrue($day25->isEquals(new Date(2013, 12, 25)));
        $this->assertTrue($day25->isEquals(new Date(2013, 1, 25)));
        $this->assertTrue($day25->isEquals(new Date(2000, 5, 25)));
    }
}
