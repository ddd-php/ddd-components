<?php

namespace Ddd\Time\Tests\Model;

use Ddd\Time\Model\Duration;
use Ddd\Time\Model\TimeUnit;
use Ddd\Time\Tests\TestCase;

class DurationTest extends TestCase
{
    public function testToSeconds()
    {
        $duration = new Duration(13, TimeUnit::minute());
        $this->assertEquals(780, $duration->toSeconds()->getValue());

        $duration = new Duration(2, TimeUnit::hour());
        $this->assertEquals(7200, $duration->toSeconds()->getValue());

        $duration = new Duration(5, TimeUnit::day());
        $this->assertEquals(432000, $duration->toSeconds()->getValue());

        $duration = new Duration(1, TimeUnit::week());
        $this->assertEquals(604800, $duration->toSeconds()->getValue());

        try {
            $duration = new Duration(2, TimeUnit::month());
            $duration->toSeconds();
            $this->assertEquals(true, false);
        } catch (\LogicException $e) {
            $this->assertEquals(true, true);
        }

    }

    public function testToMinutes()
    {
        $duration = new Duration(125, TimeUnit::second());
        $this->assertEquals(2, $duration->toMinutes()->getValue());
        $duration = new Duration(11, TimeUnit::second());
        $this->assertEquals(0, $duration->toMinutes()->getValue());

        $duration = new Duration(13, TimeUnit::minute());
        $this->assertEquals($duration, $duration->toMinutes());

        $duration = new Duration(3, TimeUnit::hour());
        $this->assertEquals(180, $duration->toMinutes()->getValue());

        $duration = new Duration(4, TimeUnit::day());
        $this->assertEquals(5760, $duration->toMinutes()->getValue());

        $duration = new Duration(2, TimeUnit::week());
        $this->assertEquals(20160, $duration->toMinutes()->getValue());

        try {
            $duration = new Duration(2, TimeUnit::year());
            $duration->toMinutes();
            $this->assertEquals(true, false);
        } catch (\LogicException $e) {
            $this->assertEquals(true, true);
        }
    }

    public function testToHours()
    {
        $duration = new Duration(8200, TimeUnit::second());
        $this->assertEquals(2, $duration->toHours()->getValue());
        $duration = new Duration(100, TimeUnit::second());
        $this->assertEquals(0, $duration->toHours()->getValue());

        $duration = new Duration(60, TimeUnit::minute());
        $this->assertEquals(1, $duration->toHours()->getValue());

        $duration = new Duration(3, TimeUnit::hour());
        $this->assertEquals($duration, $duration->toHours());

        $duration = new Duration(0, TimeUnit::day());
        $this->assertEquals(0, $duration->toHours()->getValue());
        $duration = new Duration(4, TimeUnit::day());
        $this->assertEquals(96, $duration->toHours()->getValue());

        $duration = new Duration(1, TimeUnit::week());
        $this->assertEquals(168, $duration->toHours()->getValue());

        try {
            $duration = new Duration(2, TimeUnit::year());
            $duration->toMinutes();
            $this->assertEquals(true, false);
        } catch (\LogicException $e) {
            $this->assertEquals(true, true);
        }
    }
}