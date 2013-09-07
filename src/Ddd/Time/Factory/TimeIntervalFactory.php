<?php

namespace Ddd\Time\Factory;

use Ddd\Time\Model\DateInterval;
use Ddd\Time\Model\TimeInterval;
use Ddd\Time\Model\TimePoint;

class TimeIntervalFactory
{
    const FORMAT_TIMEPOINT = 'Y-m-d G:i';

    static public function create($beginString, $endString)
    {
        $begin = \DateTime::createFromFormat(self::FORMAT_TIMEPOINT, $beginString);
        $end = \DateTime::createFromFormat(self::FORMAT_TIMEPOINT, $endString);

        if (!$begin || !$end) {
            throw new \InvalidArgumentException(sprintf('The given interval "%s,%s" does not respect the expected format: "%s,%s".', $beginString, $endString, self::FORMAT_TIMEPOINT, self::FORMAT_TIMEPOINT));
        }

        return new TimeInterval(TimePointFactory::fromDateTime($begin), TimePointFactory::fromDateTime($end));
    }

    static public function fromDateInterval(DateInterval $dateInterval)
    {
        $begin = $dateInterval->getBegin();
        $end = $dateInterval->getEnd();

        return new TimeInterval(
            new TimePoint($begin->getYear(), $begin->getMonth(), $begin->getDay(), 0, 0),
            new TimePoint($end->getYear(), $end->getMonth(), $end->getDay(), 23, 59, 59)
        );
    }
}

