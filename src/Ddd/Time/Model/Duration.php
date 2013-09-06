<?php

namespace Ddd\Time\Model;

class Duration
{
    const NB_SECOND_PER_MINUTE = 60;
    const NB_MINUTE_PER_HOUR = 60;
    const NB_HOUR_PER_DAY = 24;
    const NB_DAY_PER_WEEK = 7;

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

    public function toSeconds()
    {
        switch($this->unit->getCode()) {
            case TimeUnit::SECOND:
                return $this;
            case TimeUnit::MINUTE:
                $value = self::NB_SECOND_PER_MINUTE * $this->value;
                break;
            case TimeUnit::HOUR:
                $value = self::NB_SECOND_PER_MINUTE * self::NB_MINUTE_PER_HOUR * $this->value;
                break;
            case TimeUnit::DAY:
                $value = self::NB_SECOND_PER_MINUTE * self::NB_MINUTE_PER_HOUR 
                    * self::NB_HOUR_PER_DAY * $this->value;
                break;
            case TimeUnit::WEEK:
                $value = self::NB_SECOND_PER_MINUTE * self::NB_MINUTE_PER_HOUR 
                    * self::NB_HOUR_PER_DAY * self::NB_DAY_PER_WEEK;
                break;
            default:
               throw new \LogicException('can\'t convert some months or years to seconds.');
        }

        return new Duration($value, TimeUnit::second());
    }

    public function toMinutes()
    {
        switch($this->unit->getCode()) {
            case TimeUnit::SECOND:
                $value = floor($this->value / self::NB_SECOND_PER_MINUTE);
                break;
            case TimeUnit::MINUTE:
                return $this;
            case TimeUnit::HOUR:
                $value = $this->value * self::NB_MINUTE_PER_HOUR;
                break;
            case TimeUnit::DAY:
                $value = $this->value * self::NB_MINUTE_PER_HOUR * self::NB_HOUR_PER_DAY;
                break;
            case TimeUnit::WEEK:
                $calue = $this->value * self::NB_MINUTE_PER_HOUR * self::NB_HOUR_PER_DAY * self::NB_DAY_PER_WEEK;
                break;
            default:
                throw new \LogicException('can\'t convert some months or years to minutes.');
        }

        return new Duration($value, TimeUnit::minute());
    }

    public function toHours()
    {
        switch($this->unit->getCode()) {
            case TimeUnit::SECOND:
                $value = floor($this->value / (self::NB_SECOND_PER_MINUTE * self::NB_MINUTE_PER_HOUR));
                break;
            case TimeUnit::MINUTE:
                $value = floor($this->value / self::NB_MINUTE_PER_HOUR);
                break;
            case TimeUnit::HOUR:
                return $this;
            case TimeUnit::DAY:
                $value = $this->value * self::NB_HOUR_PER_DAY;
                break;
            case TimeUnit::WEEK:
                $value = $this->value * self::NB_HOUR_PER_DAY * self::NB_DAY_PER_WEEK;
                break;
            default:
                throw new \LogicException('can\'t convert some months or years to hours.');
        }

        return new Duration($value, TimeUnit::hour());
    }

    public function toDays()
    {
        switch($this->unit->getCode()) {
            case TimeUnit::SECOND:
                $value = floor($this->value / (self::NB_SECOND_PER_MINUTE * self::NB_MINUTE_PER_HOUR * self::NB_HOUR_PER_DAY));
                break;
            case TimeUnit::MINUTE:
                $value = floor($this->value / (self::NB_MINUTE_PER_HOUR * self::NB_HOUR_PER_DAY));
                break;
            case TimeUnit::HOUR:
                $value = floor($this->value / self::NB_HOUR_PER_DAY);
                break;
            case TimeUnit::DAY:
                return $this;
            case TimeUnit::WEEK:
                $value = $this->value * self::NB_DAY_PER_WEEK;
                break;
            default:
                throw new \LogicException('can\'t convert some months or years to days.');
        }

        return new Duration($value, TimeUnit::day());
    }

    public function toWeeks()
    {
        switch($this->unit->getCode()) {
            case TimeUnit::SECOND:
                $value = floor($this->value / (self::NB_SECOND_PER_MINUTE * self::NB_MINUTE_PER_HOUR * self::NB_HOUR_PER_DAY * self::NB_DAY_PER_WEEK));
                break;
            case TimeUnit::MINUTE:
                $value = floor($this->value / (self::NB_MINUTE_PER_HOUR * self::NB_HOUR_PER_DAY * self::NB_DAY_PER_WEEK));
                break;
            case TimeUnit::HOUR:
                $value = floor($this->value / (self::NB_HOUR_PER_DAY * self::NB_DAY_PER_WEEK));
                break;
            case TimeUnit::DAY:
                $value = floor($this->value / self::NB_DAY_PER_WEEK);
                break;
            case TimeUnit::WEEK:
                return $this;
            default:
                throw new \LogicException('can\'t convert some months or years to weeks.');
        }

       return new Duration($value, TimeUnit::day());
    }
}
