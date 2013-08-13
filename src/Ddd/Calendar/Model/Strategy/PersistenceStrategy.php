<?php

namespace Ddd\Calendar\Model\Strategy;

use Ddd\Calendar\Model\CalendarInterface;
use Ddd\Calendar\Model\EventInterface;
use Ddd\Calendar\Service\EventPersisterInterface;
use Ddd\Calendar\Service\CalendarPersisterInterface;

/**
 * Strategy decorator with persister.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class PersistenceStrategyDecorator implements StrategyInterface
{
    /**
     * @var CalendarInterface
     */
    private $calendar;

    /**
     * @var StrategyInterface
     */
    private $innerStrategy;

    /**
     * @var CalendarPersisterInterface
     */
    private $persister;

    /**
     * @param CalendarInterface          $calendar
     * @param StrategyInterface          $innerStrategy
     * @param CalendarPersisterInterface $persister
     */
    public function __construct(CalendarInterface $calendar, StrategyInterface $innerStrategy, CalendarPersisterInterface $persister)
    {
        $this->calendar      = $calendar;
        $this->innerStrategy = $innerStrategy;
        $this->persister     = $persister;
    }

    /**
     * {@inheritdoc}
     */
    public function add(EventInterface $newEvent, array $events)
    {
        $result = $this->innerStrategy->add($newEvent, $events);
        $this->persister->persist($this->calendar);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EventInterface $removedEvent, array $events)
    {
        $result = $this->innerStrategy->remove($removedEvent, $events);
        $this->persister->persist($this->calendar);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function update(EventInterface $originalEvent, EventInterface $updatedEvent, array $events)
    {
        return $this->innerStrategy->update($originalEvent, $updatedEvent, $events);
    }
}
