<?php

namespace Ddd\Slug\Infra\Transliterator;

use Ddd\Slug\Service\TransliteratorInterface;

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
