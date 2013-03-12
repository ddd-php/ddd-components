<?php

namespace Ddd\Slug\Service;

/**
 * String transliterator.
 *
 * @author Joseph Rouff <rouffj@gmail.com>
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
