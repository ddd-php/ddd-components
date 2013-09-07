<?php

namespace Ddd\Time\Tests\Factory;

use Ddd\Time\Model\TimePoint;
use Ddd\Time\Factory\TimePointFactory;
use Ddd\Time\Tests\TestCase;

class TimePointFactoryTest extends TestCase
{
    public function testFromTimestampWhenInvalidValueGiven()
    {
        $this->assertNull(TimePointFactory::fromTimestamp(null));
        $this->assertNull(TimePointFactory::fromTimestamp(0));
        $this->assertNull(TimePointFactory::fromTimestamp(false));
        $this->assertNull(TimePointFactory::fromTimestamp('times 5'));
    }

    public function testFromTimestampWhenValidValueGiven()
    {
        $this->assertEquals(new TimePoint(1970, 1, 1, 0, 0, 5), TimePointFactory::fromTimestamp(5));
        $this->assertEquals(new TimePoint(1970, 1, 1, 0, 0, 2), TimePointFactory::fromTimestamp('2*5'), 'should return UNIX time begin + 2 seconds because string starts with a number');
    }
}
