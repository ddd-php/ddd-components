<?php

namespace Ddd\Time\Tests\Model;

use Ddd\Time\Model\FixedDateInterval;
use Ddd\Time\Model\FixedDate;
use Ddd\Time\Factory\DateIntervalFactory;
use Ddd\Time\Factory\TimeIntervalFactory;
use Ddd\Time\Tests\TestCase;

class FixedDateIntervalTest extends TestCase
{
    public function testIsInclude()
    {
        $interval = new FixedDateInterval(new FixedDate(null, 13), new FixedDate(null, 15));

        $this->assertTrue($interval->isInclude(DateIntervalFactory::create('2013-01-13', '2013-01-14')));
        $this->assertTrue($interval->isInclude(DateIntervalFactory::create('2013-10-13', '2013-10-15')));
        $this->assertTrue($interval->isInclude(DateIntervalFactory::create('2013-05-14', '2013-05-15')));
        $this->assertTrue($interval->isInclude(TimeIntervalFactory::create('2013-01-13 01:00', '2013-01-14 18:30')));
    }
}
