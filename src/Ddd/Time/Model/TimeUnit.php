<?php

namespace Ddd\Time\Model;

class TimeUnit
{
    const YEAR   = 'Y';
    const MONTH  = 'M';
    const WEEK   = 'W';
    const DAY    = 'D';
    const HOUR   = 'H';
    const MINUTE = 'I';
    const SECOND = 'S';

    private $unit;

    private function __construct($unit)
    {
        $this->unit = $unit;
    }

    public function getCode()
    {
        return (self::MINUTE === $this->unit) ? 'M' : $this->unit;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function isTime()
    {
        return
            self::HOUR === $this->unit ||
            self::MINUTE === $this->unit ||
            self::SECOND === $this->unit
        ;
    }

    static public function year()
    {
        return new self(self::YEAR);
    }

    static public function month()
    {
        return new self(self::MONTH);
    }

    static public function week()
    {
        return new self(self::WEEK);
    }

    static public function day()
    {
        return new self(self::DAY);
    }

    static public function hour()
    {
        return new self(self::HOUR);
    }

    static public function minute()
    {
        return new self(self::MINUTE);
    }

    static public function second()
    {
        return new self(self::SECOND);
    }
}
