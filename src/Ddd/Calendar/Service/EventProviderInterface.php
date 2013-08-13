<?php

namespace Ddd\Calendar\Service;

interface EventProviderInterface
{
    /**
     * @return array
     */
    function getEvents();

    /**
     * @return string
     */
    function getName();
}
