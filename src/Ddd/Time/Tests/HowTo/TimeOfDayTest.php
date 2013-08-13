<?php

namespace Ddd\Time\Tests\HowTo;

use Ddd\Time\Tests\TestCase;
use Ddd\Time\Model\TimeOfDay;


class TimeOfDayTest extends TestCase
{
    public function testHowToKnowIfATimeOfDayIsBeforeAfterEqualAnOtherTimeOfDay()
    {
        $first = new TimeOfDay(14, 59, 37);
        $second = new TimeOfDay(14, 59, 38);
        $third = new TimeOfDay(15, 23); 
        $four = new TimeOfDay(15, 23);
        $this->assertEquals(true, $first->isBefore($second));
        $this->assertEquals(true, $third->isAfter($second));
        $this->assertEquals(true, $four->isEquals($third));
    }

    public function testHowToKnowIfItIsTheAnteMeridianPostMeridian()
    {
        $ante = new TimeOfDay(11, 59, 59);
        $post = new TimeOfDay(12, 37, 21);
        $this->assertEquals(true, $ante->isAnteMeridian());
        $this->assertEquals(true, $post->isPostMeridian());
    }
}
