<?php

namespace Ddd\Time\Factory;

use Ddd\Time\Model\Date;

class DateFactory
{
    static public function today()
    {
        $now = new \DateTime('now');

        return self::fromDateTime($now);
    }

    static public function fromDateTime(\DateTime $dateTime)
    {
        return new Date(
            $dateTime->format('Y'),
            $dateTime->format('m'),
            $dateTime->format('d')
        );
    }
}

