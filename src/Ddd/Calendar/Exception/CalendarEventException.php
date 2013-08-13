<?php

namespace Ddd\Calendar\Exception;

use Ddd\Calendar\Model\EventInterface;

/**
 * Calendar event exception.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class CalendarEventException extends \LogicException implements CalendarExceptionInterface
{
    /**
     * @var EventInterface
     */
    private $event;

    /**
     * @param EventInterface $event
     *
     * @return CalendarEventException
     */
    public static function addWhileFrozen(EventInterface $event)
    {
        return new self($event, 'Cannot add event to frozen calendar.');
    }

    /**
     * @param EventInterface $event
     *
     * @return CalendarEventException
     */
    public static function removeWhileFrozen(EventInterface $event)
    {
        return new self($event, 'Cannot remove event from frozen calendar.');
    }


    /**
     * @param EventInterface $event
     *
     * @return CalendarEventException
     */
    public static function updateWhileFrozen(EventInterface $event)
    {
        return new self($event, 'Cannot update event from frozen calendar.');
    }

    /**
     * @param EventInterface $event
     *
     * @return CalendarEventException
     */
    public static function eventOverlap(EventInterface $event)
    {
        return new self($event, 'Events overlap detected.');
    }

    /**
     * @param EventInterface $event
     * @param int            $message
     */
    public function __construct(EventInterface $event, $message)
    {
        parent::__construct($message);
        $this->event = $event;
    }

    /**
     * @return EventInterface
     */
    public function getEvent()
    {
        return $this->event;
    }
}
