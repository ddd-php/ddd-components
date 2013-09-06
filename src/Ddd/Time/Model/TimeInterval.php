<?php

namespace Ddd\Time\Model;

class TimeInterval implements IntervalInterface
{
    private $begin;
    private $end;

    public function __construct(TimePoint $begin, TimePoint $end)
    {
        $this->begin = $begin;
        $this->end   = $end;
    }

    public function isEquals(TimeInterval $interval)
    {
        return
            $this->begin->isEquals($interval->getBegin()) &&
            $this->end->isEquals($interval->getEnd())
        ;
    }

    public function isBefore(IntervalInterface $interval)
    {
        return $interval->getEnd()->isAfter($this->getBegin()) && $interval->getBegin()->isAfter($this->getEnd());
    }

    public function isAfter(IntervalInterface $interval)
    {
        return $this->begin->isAfter($interval->getEnd());
    }

    public function isDuring(IntervalInterface $interval)
    {
        return !$this->isBefore($interval) && !$this->isAfter($interval);
    }

    public function isPartiallyBefore(IntervalInterface $interval)
    {
        throw new \Exception('Not implemented');
    }

    public function isPartiallyAfter(IntervalInterface $interval)
    {
        throw new \Exception('Not implemented');
    }

    public function getBegin()
    {
        return $this->begin;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getLength()
    {
        $begin = $this->begin->toDateTime();
        $end   = $this->end->toDateTime();
        $diff  = $begin->diff($end);

        return new Duration($diff->format('%H'), TimeUnit::hour());
    }
}
