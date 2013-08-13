<?php

namespace Ddd\Time\Model;

class TimeOfDay
{
    private $hour;
    private $minutes;
    private $seconds;

    public function __construct($hour, $minutes, $seconds = 0)
    {
        $this->hour = (int)$hour;
        $this->minutes = (int)$minutes;
        $this->seconds = (int)$seconds;
    }

    public function isEquals(TimeOfDay $other)
    {
        return
            $this->hour === $other->getHour() &&
            $this->minutes === $other->getMinutes() &&
            $this->seconds === $other->getSeconds()
        ;
    }

    public function isBefore(TimeOfDay $other)
    {
        return
            false === $this->isEquals($other) &&
            false === $this->isAfter($other);
    }

    public function isAfter(TimeOfDay $other)
    {
        return
            $this->hour > $other->getHour() ||
            ($this->hour === $other->getHour() && $this->minutes > $other->getMinutes()) ||
            ($this->hour === $other->getHour() && $this->minutes === $other->getMinutes() && $this->seconds > $other->getSeconds())
        ;
    }

    public function isAnteMeridian()
    {
        return $this->hour < 12;
    }

    public function isPostMeridian()
    {
        return false === $this->isAnteMeridian();
    }

    public function __toString()
    {
        $hour = ($this->hour < 10) ? '0'.$this->hour : $this->hour;
        $minutes = ($this->minutes < 10) ? '0'.$this->minutes : $this->minutes;

        return $hour.':'.$minutes;
    }

    /**
     * Gets the value of hour
     *
     * @return int
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * Gets the value of minutes
     *
     * @return int
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * Gets the value of minutes
     *
     * @return int
     */
    public function getSeconds()
    {
        return $this->seconds;
    }
}

