<?php

namespace Ddd\Time\Factory;

use Ddd\Time\Model\Date;
use Ddd\Time\Model\DateInterval;

class DateIntervalFactory
{
    const FORMAT_DATE = 'Y-m-d';

    static public function today()
    {
        $now = new \DateTime();

        return new Date(
            $now->format('Y'),
            $now->format('m'),
            $now->format('d')
        );
    }

    static public function create($beginString, $endString)
    {
        $begin = \DateTime::createFromFormat(self::FORMAT_DATE, $beginString);
        $end = \DateTime::createFromFormat(self::FORMAT_DATE, $endString);

        if (!$begin || !$end) {
            throw new \InvalidArgumentException(sprintf('The given interval "%s,%s" does not respect the expected format: "%s,%s".', $beginString, $endString, self::FORMAT_DATE, self::FORMAT_DATE));
        }

        return new DateInterval(DateFactory::fromDateTime($begin), DateFactory::fromDateTime($end));
    }
}

