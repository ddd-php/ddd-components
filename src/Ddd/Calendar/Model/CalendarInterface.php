<?php

namespace Ddd\Calendar\Model;

use Ddd\Time\Model\TimePoint;
use Ddd\Time\Model\TimeInterval;
use Ddd\Calendar\Model\EventInterface;
use Ddd\Time\Factory\TimePointFactory;
use Ddd\Calendar\Service\EventProviderInterface;

/**
 * Calendar interface
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface CalendarInterface extends \IteratorAggregate, \Countable, \ArrayAccess
{
    /**
     * @param TimeInterval $interval
     * @param string       $title
     *
     * @return CalendarInterface
     */
    public function between(TimeInterval $interval, $title = '');

    /**
     * @param EventInterface $newEvent
     */
    public function add(EventInterface $newEvent);

    /**
     * @param EventInterface $event
     */
    public function remove(EventInterface $event);

    /**
     * @param EventInterface $originalEvent
     * @param EventInterface $updatedEvent
     */
    public function update(EventInterface $originalEvent, EventInterface $updatedEvent);

    /**
     * @param TimePoint $cursor
     */
    public function setCursor(TimePoint $cursor);

    /**
     * @return TimePoint
     */
    public function getCursor();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * {@inheritdoc}
     */
    public function countRemaining();
}
