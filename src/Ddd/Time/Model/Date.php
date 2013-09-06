<?php

namespace Ddd\Time\Model;

class Date
{
    const SUNDAY = 0;
    const SATURDAY = 6;

    private $year;
    private $month;
    private $day;

    public function __construct($year, $month, $day)
    {
        $this->day   = (int) $day;
        $this->month = (int) $month;
        $this->year  = (int) $year;
    }

    public function during(Duration $duration)
    {
        $begin = new TimePoint($this->year, $this->month, $this->day, 0, 0);
        $end = $begin->plus($duration);

        return new DateInterval($begin->getDate(), $end->getDate());
    }

    public function minus(Duration $duration)
    {
        return $this->toTimePoint()->minus($duration)->getDate();
    }

    public function plus(Duration $duration)
    {
        return $this->toTimePoint()->plus($duration)->getDate();
    }

    public function isAfter(Date $date)
    {
        return
            $this->year > $date->getYear() ||
            ($this->year >= $date->getYear() && $this->month > $date->getMonth()) ||
            ($this->year >= $date->getYear() && $this->month >= $date->getMonth() && $this->day > $date->getDay())
        ;
    }

    public function diff(Date $date)
    {
        return new Duration($this->toDateTime()->diff($date->toDateTime())->d, TimeUnit::day());
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
        return
            $this->year === $date->getYear() &&
            $this->month === $date->getMonth() &&
            $this->day === $date->getDay()
        ;
    }

    public function beginOfWeek()
    {
        $i = 0;
        $curDate = $this;
        while ($i < 8) {
            $dtime = $curDate->toDateTime();
            $numOfWeek = (int) $dtime->format('N');
            if (1 === $numOfWeek) {
                return $curDate;
            }
            $curDate = $curDate->previous();
            $i = $i + 1;
        }
        throw new \RunTimeException('Loop error with begin of week');
    }

    public function next()
    {
        return $this->plus(new Duration(1, TimeUnit::day()));
    }

    public function previous()
    {
        return $this->minus(new Duration(1, TimeUnit::day()));
    }

    public function toDateTime()
    {
        $dateTime = new \Datetime();
        $dateTime->setDate($this->year, $this->month, $this->day);
        $dateTime->setTime(0, 0, 0);

        return $dateTime;
    }

    public function toTimePoint()
    {
        return new TimePoint($this->year, $this->month, $this->day, null, null);
    }

    public function toDateInterval()
    {
        return new DateInterval($this, $this);
    }

    public function isWeekDay()
    {
        return !$this->isWeekEndDay();
    }

    public function isWeekEndDay()
    {
        return intval($this->toDateTime()->format('w')) === self::SUNDAY || intval($this->toDateTime()->format('w')) === self::SATURDAY;
    }

    /**
     * Gets the value of year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
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
