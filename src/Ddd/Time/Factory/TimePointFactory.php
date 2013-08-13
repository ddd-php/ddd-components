<?php

namespace Ddd\Time\Factory;

use Ddd\Time\Model\TimePoint;

class TimePointFactory
{
    static public function now()
    {
        $now = new \DateTime('now');

        return self::fromDateTime($now);
    }

    static public function fromTimestamp($timestamp)
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timestamp);

        return self::fromDateTime($dateTime);
    }

    static public function fromDateTime(\DateTime $dateTime)
    {
        return new TimePoint(
            $dateTime->format('Y'),
            $dateTime->format('m'),
            $dateTime->format('d'),
            $dateTime->format('H'),
            $dateTime->format('i'),
            $dateTime->format('s')
        );
    }
}

