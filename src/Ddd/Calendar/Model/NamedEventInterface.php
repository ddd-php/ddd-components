<?php

namespace Ddd\Calendar\Model;

interface NamedEventInterface extends EventInterface
{
    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}
