<?php

namespace Ddd\Slugify\Infra\Transliterator;

use Ddd\Slugify\Service\TransliteratorInterface;

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
