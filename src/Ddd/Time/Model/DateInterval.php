<?php

namespace Ddd\Time\Model;

class DateInterval implements IntervalInterface
{
    private $begin;
    private $current;
    private $end;

    public function __construct(Date $begin, Date $end)
    {
        if ($end->isBefore($begin)) {
            throw new \Exception('DateInterval: the begin date must be before the end date.');
        }

        $this->begin   = $begin;
        $this->end     = $end;
        $this->current = $this->begin;
    }

    public function nextDate()
    {
        $this->current = $this->current->next();

        return !$this->current->isAfter($this->end);
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
     * Gets the begin value
     *
     * @return Date
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Gets the end value
     *
     * @return Date
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param IntervalInterface $other
     * @return bool
     */
    public function isBefore(IntervalInterface $other)
    {
        $begin = ($other instanceof TimeInterval) ? $other->getBegin()->getDate() : $other->getBegin();
        $end = ($other instanceof TimeInterval) ? $other->getEnd()->getDate() : $other->getEnd();

        return $this->begin->isBefore($begin) && $this->begin->isBefore($end);
    }

    /**
     * @param IntervalInterface $other
     * @return bool
     */
    public function isAfter(IntervalInterface $other)
    {
        $begin = ($other instanceof TimeInterval) ? $other->getBegin()->getDate() : $other->getBegin();
        $end = ($other instanceof TimeInterval) ? $other->getEnd()->getDate() : $other->getEnd();

        return $this->begin->isAfter($begin) && $this->begin->isAfter($end);
    }

    /**
     * @param IntervalInterface $other
     * @return bool
     */
    public function isDuring(IntervalInterface $other)
    {
        $begin = $this->begin->toDateTime();
        $end = $this->end->toDateTime();

        return
            $begin === max($begin, $other->getBegin()->toDateTime()) &&
            $end   === min($end, $other->getEnd()->toDateTime())
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

    public function isInclude(IntervalInterface $other)
    {
        $otherBegin = ($other instanceof TimeInterval) ? $other->getBegin()->getDate() : $other->getBegin();
        $otherEnd = ($other instanceof TimeInterval) ? $other->getEnd()->getDate() : $other->getEnd();

        return
            ($this->begin->isBefore($otherBegin) || $this->begin->isEquals($otherBegin)) &&
            ($this->end->isAfter($otherEnd) || $this->end->isEquals($otherEnd))
        ;
    }
}

