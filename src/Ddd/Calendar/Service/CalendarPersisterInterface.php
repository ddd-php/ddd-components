<?php

namespace Ddd\Calendar\Service;

use Ddd\Calendar\Model\CalendarInterface;
use Ddd\Calendar\Model\EventInterface;

interface CalendarPersisterInterface
{
    /**
     * @param CalendarInterface $calendar
     */
    function persist(CalendarInterface $calendar);
}
