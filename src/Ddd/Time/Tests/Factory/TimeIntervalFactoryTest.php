<?php

namespace Ddd\Time\Tests\Factory;

use Ddd\Time\Model\TimePoint;
use Ddd\Time\Model\TimeInterval;
use Ddd\Time\Factory\TimeIntervalFactory;
use Ddd\Time\Tests\TestCase;

class TimeIntervalFactoryTest extends TestCase
{
    public function testCreateWhenInvalidFormat()
    {
        try {
            $interval = TimeIntervalFactory::create('2010-01-01 00', '2010-01-01 05:00');
            $this->fail('An exception should be thrown');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('The given interval "2010-01-01 00,2010-01-01 05:00" does not respect the expected format: "Y-m-d G:i,Y-m-d G:i".', $e->getMessage());
        }
    }

    public function testCreateWhenValidFormat()
    {
        $interval = TimeIntervalFactory::create('2010-01-01 00:00', '2010-01-01 05:00');
        $this->assertEquals(new TimeInterval(new TimePoint(2010, 1, 1, 0, 0), new TimePoint(2010, 1, 1, 5, 0)), $interval);
    }
}
