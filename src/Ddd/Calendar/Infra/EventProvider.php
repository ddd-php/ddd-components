<?php

namespace Rouffj\Ddd\Calendar\Infra;

/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class EventProvider implements EventProviderInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $events;

    /**
     * @param string $name
     * @param array  $events
     */
    public function __construct($name, array $events)
    {
        $this->name = $name;
        $this->events = $events;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
