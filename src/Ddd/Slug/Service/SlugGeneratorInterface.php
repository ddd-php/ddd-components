<?php

namespace Ddd\Slug\Service;

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
     * @param array $fieldValues
     *
     * @return string
     */
    public function slugify(array $fieldValues);
}
