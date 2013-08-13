<?php

namespace Ddd\Calendar\Model;

use Ddd\Time\Model\TimeInterval;

class SendableEvent extends Event implements SendableEventInterface
{
    /**
     * @var string
     */
    private $organizer;

    /**
     * @var array
     */
    private $guests;

    /**
     * @param TimeInterval $interval
     * @param string       $organizer
     */
    public function __construct(TimeInterval $interval, $organizer)
    {
        parent::__construct($interval);
        $this->organizer = $organizer;
        $this->guests = array();
    }

    /**
     * @return string
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function addGuest($guest)
    {
        $this->guests[] = $guest;
    }

    public function removeGuest($guest)
    {
        if ($index = array_search($guest, $this->guests)) {
            array_slice($this->guests, $index, 1);
        }
    }

    public function hasGuest($guest)
    {
        return in_array($guest, $this->guests);
    }

    /**
     * @return array
     */
    public function getGuests()
    {
        return $this->guests;
    }
}
