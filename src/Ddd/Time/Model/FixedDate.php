<?php

namespace Ddd\Time\Model;

class FixedDate
{
    private $month;
    private $day;

    public function __construct($month, $day)
    {
        $this->month = (null === $month) ? null : (int) $month;
        $this->day   = (int) $day;
    }

    public function isAfter(Date $date)
    {
        if (!$this->month) {
            return $this->day > $date->getDay();
        }

        return
            $this->month > $date->getMonth() ||
            ($this->month >= $date->getMonth() && $this->day > $date->getDay())
        ;
    }

    public function isBefore(Date $date)
    {
        return
            false === $this->isAfter($date) &&
            false === $this->isEquals($date)
        ;
    }

    public function isEquals(Date $date)
    {
        if (!$this->month) {
            return $this->day === $date->getDay();
        }

        return
            $this->month === $date->getMonth() &&
            $this->day === $date->getDay()
        ;
    }

    /**
     * Gets the value of month
     *
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Gets the value of day
     *
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }
}
