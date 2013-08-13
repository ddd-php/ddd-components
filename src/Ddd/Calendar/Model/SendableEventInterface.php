<?php

namespace Ddd\Calendar\Model;

interface SendableEventInterface extends EventInterface
{
    /**
     * @return string
     */
    function getOrganizer();

    /**
     * @return array
     */
    function getGuests();
}
