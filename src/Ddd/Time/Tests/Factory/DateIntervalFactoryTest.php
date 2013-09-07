<?php

namespace Ddd\Time\Tests\Factory;

use Ddd\Time\Model\Date;
use Ddd\Time\Model\DateInterval;
use Ddd\Time\Factory\DateIntervalFactory;
use Ddd\Time\Tests\TestCase;

class DateIntervalFactoryTest extends TestCase
{
    public function testCreateWhenInvalidFormat()
    {
        try {
            $interval = DateIntervalFactory::create('2010-01', '2010-01-02');
            $this->fail('An exception should be thrown');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('The given interval "2010-01,2010-01-02" does not respect the expected format: "Y-m-d,Y-m-d".', $e->getMessage());
        }
    }

    public function testCreateWhenValidFormat()
    {
        $interval = DateIntervalFactory::create('2010-01-01', '2010-01-02');
        $this->assertEquals(new DateInterval(new Date(2010, 1, 1), new Date(2010, 1, 2)), $interval);
    }
}
