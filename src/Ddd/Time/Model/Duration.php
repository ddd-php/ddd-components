<?php

namespace Ddd\Time\Model;

class Duration
{
    private $value = null;
    private $unit = null;

    public function __construct($duration, TimeUnit $unit)
    {
        $this->value = $duration;
        $this->unit = $unit;
    }

    public function asPHPDateInterval()
    {
        $timeSpec = ($this->unit->isTime()) ? 'PT' : 'P';
        $timeSpec = sprintf('%s%s%s', $timeSpec, $this->value, $this->unit->getCode());

        return new \DateInterval($timeSpec);
    }

    public function getValue()
    {
        return $this->value;
    }
}
