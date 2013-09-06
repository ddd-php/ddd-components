<?php

namespace Ddd\Time\Model;

class DateInterval implements IntervalInterface
{
    private $begin;
    private $current;
    private $end;

    public function __construct(Date $beginDate, Date $endDate)
    {
        if ($endDate->isBefore($beginDate)) {
            throw new \Exception('DateInterval: the begin date must be before the end date.');
        }

        $this->begin = $beginDate;
        $this->end = $endDate;
        $this->current = $this->begin;
    }

    public function nextDate()
    {
        $this->current = $this->current->next();
        return false === $this->current->isAfter($this->end);
    }

    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Get duration in days separating the begin and end date of DateInterval.
     *
     * @return Duration Expressed in days.
     */
    public function getDuration()
    {
        return $this->begin->diff($this->end);
    }

    /**
     * Gets the value of begin
     *
     * @return
     */
    public function getBegin()
    {
        return $this->begin;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function isBefore(IntervalInterface $other)
    {
        $begin = ($other instanceof TimeInterval) ? $other->getBegin()->getDate() : $other->getBegin();
        $end = ($other instanceof TimeInterval) ? $other->getEnd()->getDate() : $other->getEnd();

        return $this->begin->isBefore($begin) && $this->begin->isBefore($end);
    }

    public function isAfter(IntervalInterface $other)
    {
        $begin = ($other instanceof TimeInterval) ? $other->getBegin()->getDate() : $other->getBegin();
        $end = ($other instanceof TimeInterval) ? $other->getEnd()->getDate() : $other->getEnd();

        return $this->begin->isAfter($begin) && $this->begin->isAfter($end);
    }

    public function isDuring(IntervalInterface $other)
    {
        $begin = $this->begin->toDateTime();
        $end = $this->end->toDateTime();

        return
            $begin === max($begin, $other->getBegin()->toDateTime()) &&
            $end === min($end, $other->getEnd()->toDateTime())
        ;
    }

    public function isPartiallyBefore(IntervalInterface $interval)
    {
        throw new \Exception('Not implemented');
    }

    public function isPartiallyAfter(IntervalInterface $interval)
    {
        throw new \Exception('Not implemented');
    }
}

