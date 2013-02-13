<?php

namespace Rouffj\Slugify\Infra\Transliterator;

use Rouffj\Slugify\Service\TransliteratorInterface;

/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class PassthruTransliterator implements TransliteratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function transliterate($string)
    {
        return $string;
    }
}
