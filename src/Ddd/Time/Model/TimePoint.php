<?php

namespace Ddd\Time\Model;

use Ddd\Time\Factory\TimePointFactory;

class TimePoint
{
    private $date;
    private $time;

    public function __construct($year, $month, $day, $hour, $minute, $second = 0)
    {
        $this->date = new Date($year, $month, $day);
        $this->time = new TimeOfDay($hour, $minute, $second);
    }

    public function during(Duration $duration)
    {
        $interval = $this->plus($duration);

        return new TimeInterval($this, $interval);
    }

    public function until(TimePoint $point)
    {
        return new TimeInterval($this, $point);
    }

    public function plus(Duration $duration)
    {
        $date = $this->toDateTime();
        $date->add($duration->asPHPDateInterval());

        return TimePointFactory::fromDateTime($date);
    }

    public function minus(Duration $duration)
    {
        $date = $this->toDateTime();
        $date->sub($duration->asPHPDateInterval());

        return TimePointFactory::fromDateTime($date);
    }

    public function isAfter(TimePoint $point)
    {
         if ($this->date->isEquals($point->getDate())) {
            if ($this->time->isAfter($point->getTimeOfDay())){
                return true;
            }
         } else if ($this->date->isAfter($point->getDate())) {
            return true;
         }

        return false;
    }

    public function isBefore(TimePoint $other)
    {
        return 
            !$this->isAfter($other) &&
            !$this->isEquals($other);
    }

    public function isEquals(TimePoint $point)
    {
        return
            $this->date->isEquals($point->getDate()) &&
            $this->time->isEquals($point->getTimeOfDay())
        ;
    }

    /**
     * Gets the value of year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->date->getYear();
    }

    /**
     * Gets the value of month
     *
     * @return int
     */
    public function getMonth()
    {
        return $this->date->getMonth();
    }

    /**
     * Gets the value of day
     *
     * @return int
     */
    public function getDay()
    {
        return $this->date->getDay();;
    }

    public function getHour()
    {
        return $this->time->getHour();
    }

    public function getMinutes()
    {
        return $this->time->getMinutes();
    }

    public function getSeconds()
    {
        return $this->time->getSeconds();
    }

    public function toDateTime()
    {
        $dtime = $this->date->toDateTime();
        $dtime->setTime($this->time->getHour(), $this->time->getMinutes(), $this->time->getSeconds());

        return $dtime;
    }

    public function toTimeInterval()
    {
        return new TimeInterval($this, $this);
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTimeOfDay()
    {
        return $this->time;
    }

    public function isNightTime($latitude, $longitude)
    {
        $yesterdaySunset = date_sunset($this->date->previous()->toDateTime()->getTimestamp(), SUNFUNCS_RET_TIMESTAMP, $latitude, $longitude);
        $todaySunrise = date_sunrise($this->date->toDateTime()->getTimestamp(), SUNFUNCS_RET_TIMESTAMP, $latitude, $longitude);

        if (false === $yesterdaySunset || false === $todaySunrise) {
            throw new \RuntimeException('PHP could not determine the sun information.');
        }

        return ($this->isAfter(TimePointFactory::fromTimestamp($yesterdaySunset))
            && $this->isBefore(TimePointFactory::fromTimestamp($todaySunrise)));
    }

    public function __toString()
    {
        return strtr('{year}/{month}/{day} at {time}', array(
            '{year}' => $this->date->getYear(),
            '{month}' => $this->date->getMonth(),
            '{day}' => $this->date->getDay(),
            '{time}' => $this->time,
        ));
    }
}
