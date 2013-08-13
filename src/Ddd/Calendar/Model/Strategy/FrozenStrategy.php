<?php

namespace Ddd\Calendar\Model\Strategy;

use Ddd\Calendar\Model\EventInterface;
use Ddd\Calendar\Exception\CalendarEventException;

/**
 * Strategy which don't permit anything.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class FrozenStrategy implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function add(EventInterface $newEvent, array $events)
    {
        throw CalendarEventException::addWhileFrozen($newEvent);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EventInterface $removedEvent, array $events)
    {
        throw CalendarEventException::removeWhileFrozen($removedEvent);
    }
    /**
     * {@inheritdoc}
     */
    public function update(EventInterface $originalEvent, EventInterface $updatedEvent, array $events)
    {
        throw CalendarEventException::updateWhileFrozen($originalEvent);
    }
}
