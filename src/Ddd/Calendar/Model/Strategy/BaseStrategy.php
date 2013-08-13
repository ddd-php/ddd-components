<?php

namespace Ddd\Calendar\Model\Strategy;

use Ddd\Calendar\Model\EventInterface;
use Ddd\Calendar\Exception\CalendarExceptionInterface;

/**
 * Base strategy which permit everything.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class BaseStrategy implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function add(EventInterface $newEvent, array $events)
    {
        $index = 0;
        foreach ($events as $event) {
            if ($newEvent->getInterval()->isBefore($event->getInterval())) {
                array_splice($events, $index, 0, array($newEvent));

                return $events;
            }
            $index ++;
        }
        $events[] = $newEvent;

        return $events;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EventInterface $removedEvent, array $events)
    {
        $index = 0;
        foreach ($events as $event) {
            if ($removedEvent->isEquals($event)) {
                array_splice($events, $index, 1);
            } else {
                $index ++;
            }
        }

        return $events;
    }

    /**
     * {@inheritdoc}
     */
    public function update(EventInterface $originalEvent, EventInterface $updatedEvent, array $events)
    {
        $events = $this->add($updatedEvent, $events);

        try {
            $events = $this->remove($originalEvent, $events);
        } catch (CalendarExceptionInterface $exception) {
            $this->remove($updatedEvent, $events);

            throw $exception;
        }

        return $events;
    }
}
