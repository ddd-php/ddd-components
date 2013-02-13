<?php

namespace Rouffj\Slugify\Service;

/**
 * String transliterator.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
interface TransliteratorInterface
{
    /**
     * Transliterates given string to ascii.
     *
     * @param string $string
     *
     * @return string
     */
    public function transliterate($string);
}
