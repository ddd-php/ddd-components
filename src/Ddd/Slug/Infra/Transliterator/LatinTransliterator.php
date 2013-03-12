<?php

namespace Ddd\Slug\Infra\Transliterator;

use Ddd\Slug\Service\TransliteratorInterface;

/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class LatinTransliterator implements TransliteratorInterface
{
    /**
     * @var string
     */
    private $inputEncoding;

    /**
     * @param string $inputEncoding
     */
    public function __construct($inputEncoding = 'utf-8')
    {
        $this->inputEncoding = $inputEncoding;
    }

    /**
     * {@inheritdoc}
     */
    public function transliterate($string)
    {
        return iconv($this->inputEncoding, 'us-ascii//TRANSLIT', $string);
    }
}
