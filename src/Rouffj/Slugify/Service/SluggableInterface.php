<?php

namespace Rouffj\Slugify\Service;

/**
 * Interface for sluggable entities.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
interface SluggableInterface
{
    /**
     * Slugifies entity using given slugifier.
     *
     * @param SlugGeneratorInterface $slugifier
     */
    public function slugify(SlugGeneratorInterface $slugifier);
}
