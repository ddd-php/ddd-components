<?php

namespace Ddd\Calendar\Model;

interface EventInterface
{
    /**
     * @return \Ddd\Time\Model\TimeInterval
     */
    function getInterval();

    /**
     * @param EventInterface $event
     *
     * @return bool
     */
    function isEquals(EventInterface $event);
}
