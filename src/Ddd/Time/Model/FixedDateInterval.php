<?php

namespace Ddd\Time\Model;

class FixedDateInterval implements IntervalInterface
{
    private $begin;
    private $end;

    public function __construct(FixedDate $begin, FixedDate $end)
    {
        $this->begin   = $begin;
        $this->end     = $end;
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

    public function isInclude(IntervalInterface $other)
    {
        if ($other instanceof TimeInterval) {
            $otherBegin = $other->getBegin()->getDate();
            $otherEnd = $other->getEnd()->getDate();
        } else {
            $otherBegin = $other->getBegin();
            $otherEnd = $other->getEnd();
        }

        return
            ($this->begin->isBefore($otherBegin) || $this->begin->isEquals($otherBegin)) &&
            ($this->end->isAfter($otherEnd) || $this->end->isEquals($otherEnd))
        ;
    }

    /**
     * @param IntervalInterface $other
     * @return bool
     */
    public function isBefore(IntervalInterface $other)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @param IntervalInterface $other
     * @return bool
     */
    public function isAfter(IntervalInterface $other)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @param IntervalInterface $other
     * @return bool
     */
    public function isDuring(IntervalInterface $other)
    {
        throw new \Exception('Not implemented');
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

