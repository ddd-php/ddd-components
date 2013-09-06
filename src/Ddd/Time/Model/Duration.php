<?php

namespace Ddd\Time\Model;

class Duration
{
    const NB_SECOND_PER_MINUTE = 60;
    const NB_SECOND_PER_HOUR   = 3600;
    const NB_SECOND_PER_DAY    = 86400;
    const NB_SECOND_PER_WEEK   = 604800;
    const NB_MINUTE_PER_HOUR   = 60;
    const NB_MINUTE_PER_DAY    = 1440;
    const NB_MINUTE_PER_WEEK   = 10080;
    const NB_HOUR_PER_DAY      = 24;
    const NB_HOUR_PER_WEEK     = 168;
    const NB_DAY_PER_WEEK      = 7;

    private $value = null;
    private $unit  = null;

    public function __construct($duration, TimeUnit $unit)
    {
        $this->value = $duration;
        $this->unit  = $unit;
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
        if ($this->unit->getUnit() == TimeUnit::SECOND) {
            return $this;
        }

        if ($this->unit->getUnit() == TimeUnit::MINUTE) {
            return new Duration(self::NB_SECOND_PER_MINUTE * $this->value, TimeUnit::second());
        }

        if ($this->unit->getUnit() == TimeUnit::HOUR) {
            return new Duration(self::NB_SECOND_PER_HOUR * $this->value, TimeUnit::second());
        }

        if ($this->unit->getUnit() == TimeUnit::DAY) {
            return new Duration(self::NB_SECOND_PER_DAY * $this->value, TimeUnit::second());
        }

        if ($this->unit->getUnit() == TimeUnit::WEEK) {
            return new Duration(self::NB_SECOND_PER_WEEK, TimeUnit::second());
        }

        throw new \LogicException('can\'t convert some months or years to seconds.');
    }

    public function toMinutes()
    {
        if ($this->unit->getUnit() == TimeUnit::MINUTE) {
            return $this;
        }

        if ($this->unit->getUnit() ==  TimeUnit::SECOND) {
            return new Duration(floor($this->value / self::NB_SECOND_PER_MINUTE), TimeUnit::minute());
        }

        if ($this->unit->getUnit() == TimeUnit::HOUR) {
            return new Duration(self::NB_MINUTE_PER_HOUR * $this->value, TimeUnit::minute());
        }

        if ($this->unit->getUnit() == TimeUnit::DAY) {
            return new Duration(self::NB_MINUTE_PER_DAY * $this->value, TimeUnit::minute());
        }

        if ($this->unit->getUnit() == TimeUnit::WEEK) {
            return new Duration(self::NB_MINUTE_PER_WEEK * $this->value, TimeUnit::minute());
        }

        throw new \LogicException('can\'t convert some months or years to minutes.');
    }

    public function toHours()
    {
        if ($this->unit->getUnit() == TimeUnit::HOUR) {
            return $this;
        }

        if ($this->unit->getUnit() == TimeUnit::SECOND) {
            return new Duration(floor($this->value / (self::NB_SECOND_PER_HOUR)), TimeUnit::hour());
        }

        if ($this->unit->getUnit() == TimeUnit::MINUTE) {
            return new Duration(floor($this->value / self::NB_MINUTE_PER_HOUR), TimeUnit::hour());
        }

        if ($this->unit->getUnit() == TimeUnit::DAY) {
            return new Duration(self::NB_HOUR_PER_DAY * $this->value, TimeUnit::hour());
        }

        if ($this->unit->getUnit() == TimeUnit::WEEK) {
            return new Duration(self::NB_HOUR_PER_WEEK * $this->value, TimeUnit::hour());
        }

        throw new \LogicException('can\'t convert some months or years to hours.');
    }

    public function toDays()
    {
        if ($this->unit->getUnit() == TimeUnit::DAY) {
            return $this;
        }

        if ($this->unit->getUnit() == TimeUnit::SECOND) {
            return new Duration(floor($this->value / self::NB_SECOND_PER_DAY), TimeUnit::day());
        }

        if ($this->unit->getUnit() == TimeUnit::MINUTE) {
            return new Duration(floor($this->value / self::NB_MINUTE_PER_DAY), TimeUnit::day());
        }

        if ($this->unit->getUnit() == TimeUnit::HOUR) {
            return new Duration(floor($this->value/ self::NB_HOUR_PER_DAY), TimeUnit::day());
        }

        if ($this->unit->getUnit() == TimeUnit::WEEK) {
            return new Duration(self::NB_DAY_PER_WEEK * $this->value, TimeUnit::day());
        }

        throw new \LogicException('can\'t convert some months or years to days.');
    }

    public function toWeeks()
    {
        if ($this->unit->getUnit() == TimeUnit::WEEK) {
            return $this;
        }

        if ($this->unit->getUnit() == TimeUnit::SECOND) {
            return new Duration(floor($this->value / self::NB_SECOND_PER_WEEK), TimeUnit::week());
        }

        if ($this->unit->getUnit() == TimeUnit::MINUTE) {
            return new Duration(floor($this->value / self::NB_MINUTE_PER_WEEK), TimeUnit::week());
        }

        if ($this->unit->getUnit() == TimeUnit::HOUR) {
            return new Duration(floor($this->value / self::NB_HOUR_PER_WEEK), TimeUnit::week());
        }

        if ($this->unit->getUnit() == TimeUnit::DAY) {
            return new Duration(floor($this->value / self::NB_DAY_PER_WEEK), TimeUnit::week());
        }

        throw new \LogicException('can\'t convert some months or years to weeks.');
    }
}
