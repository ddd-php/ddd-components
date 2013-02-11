<?php

namespace Rouffj\Slugify\Service;

/**
 * Interface for slugifiers.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
interface SlugGeneratorInterface
{
    /**
     * Slugifies an array of string values.
     *
     * @param array $values
     *
     * @return string
     */
    public function slugify(array $values);
}
