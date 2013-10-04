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

    private $value;
    private $unit;
    private $year;
    private $month;

    public function __construct($duration, TimeUnit $unit, $year = null, $month = null)
    {
        $this->value = $duration;
        $this->unit  = $unit;

        if (TimeUnit::MONTH === $unit->getUnit() && (null === $year || null === $month)) {
            throw new \InvalidArgumentException(sprintf('Year and month should be provided to determine the duration.'));
        }

        if (TimeUnit::YEAR === $unit->getUnit() && null === $year) {
            throw new \InvalidArgumentException(sprintf('Year should be provided to determine the duration.'));
        }

        $this->year = $year;
        $this->month = $month;
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

        if ($this->unit->getUnit() == TimeUnit::MONTH) {
            return $this->toDays()->toSeconds();
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

        if ($this->unit->getUnit() == TimeUnit::MONTH) {
            return $this->toDays()->toMinutes();
        }

        throw new \LogicException('can\'t convert some years to minutes.');
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

        if ($this->unit->getUnit() == TimeUnit::MONTH) {
            return $this->toDays()->toHours();
        }

        throw new \LogicException('can\'t convert some years to hours.');
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

        if ($this->unit->getUnit() == TimeUnit::MONTH) {
            $numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
            $firstMonth = new \DateTime();
            $firstMonth->setDate($this->year, $this->month, 1);
            $endMonth = new \DateTime();
            $endMonth->setDate($this->year, $this->month, 1);
            $endMonth->add(new \DateInterval('P'.$this->value.'M'));
            $interval = $firstMonth->diff($endMonth);

            return new Duration($interval->days, TimeUnit::day());
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
