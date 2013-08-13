<?php

namespace Ddd\Calendar\Model;

use Ddd\Time\Model\TimeInterval;

class Event implements EventInterface
{
    private $interval;

    public function __construct(TimeInterval $interval)
    {
        $this->interval = $interval;
    }

    public function getInterval()
    {
        return $this->interval;
    }

    public function isEquals(EventInterface $event)
    {
        return $this->interval->getBegin()->isEquals($event->getInterval()->getBegin())
            && $this->interval->getEnd()->isEquals($event->getInterval()->getEnd());
    }
}
