<?php

namespace Ddd\Slug\Service;

/**
 * Interface for slugifiers.
 *
 * @author Joseph Rouff <rouffj@gmail.com>
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
interface SlugGeneratorInterface
{
    /**
     * Slugifies an array of string values.
     *
     * @param array $fieldValues
     * @param array $options      See implementations for available options
     *
     * @return string
     */
    public function slugify(array $fieldValues, array $options = array());
}
