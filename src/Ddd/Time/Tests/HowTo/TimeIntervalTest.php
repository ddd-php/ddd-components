<?php

namespace Ddd\Time\Tests\HowTo;

use Ddd\Time\Tests\TestCase;
use Ddd\Time\Factory\TimeIntervalFactory;

class TimeIntervalTest extends TestCase
{
    public function testHowToKnowIfATimeIntervalIsBeforeAfterDuringAnOtherTimeInterval()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowIfATimeIntervalIsBeforeAfterDuringAGivenDateInterval()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowIfATimeIntervalIsBeforeAfterDuringAGivenDate()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowIfATimeIntervalIsBeforeAfterDuringAGivenDateTime()
    {
        $this->markTestIncomplete();
    }

    public function testHowToTransformATimeIntervalIntoADateIntervalDestroyData()
    {
        $this->markTestIncomplete();
    }

    public function testHowToKnowHowLongATimeIntervalAreInAtLeastSecondsMinutesHoursDaysWeeksYears()
    {
        $this->markTestIncomplete();
    }

    /**
     * Use cases:
     * - Retrieve from a parameters file a time interval in its string represention.
     */
    public function testHowToTransformStringRepresentationOfTimeIntervalIntoAnObject()
    {
        $intervalInString = '2013-01-01 04:00,2013-02-02 06:00';
        list($begin, $end) = explode(',', $intervalInString);
        $interval = TimeIntervalFactory::create($begin, $end);

        $this->assertInstanceOf('Ddd\Time\Model\TimeInterval', $interval);
    }
}
