<?php

namespace Ddd\Calendar\Service;

use Ddd\Calendar\Model\EventInterface;

interface EventPersisterInterface
{
    /**
     * @param EventInterface $event
     */
    function addEvent(EventInterface $event);

    /**
     * @param EventInterface $event
     */
    function removeEvent(EventInterface $event);
}
