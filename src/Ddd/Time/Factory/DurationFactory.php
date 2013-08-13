<?php

namespace Ddd\Time\Factory;

use Ddd\Time\Model\TimeUnit;
use Ddd\Time\Model\Duration;

class DurationFactory
{
    static public function year($value)
    {
        return new Duration($value, TimeUnit::year());
    }

    static public function month($value)
    {
        return new Duration($value, TimeUnit::month());
    }

    static public function day($value)
    {
        return new Duration($value, TimeUnit::day());
    }
}
