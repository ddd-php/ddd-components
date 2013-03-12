<?php

namespace Ddd\Slug\Infra\Transliterator;

use Ddd\Slug\Service\TransliteratorInterface;

/**
 * @author Joseph Rouff <rouffj@gmail.com>
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class LatinTransliterator implements TransliteratorInterface
{
    /**
     * @var string
     */
    private $inputEncoding;

    /**
     * @todo: enumerate here all possible accents
     */
    private $availableAccents = array(
        '\'', '`', '^', '~'
    );

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
        $transliteration = iconv($this->inputEncoding, 'us-ascii//TRANSLIT', $string);

        return ('Darwin' === PHP_OS) ? $this->removeAloneAccents($transliteration) : $transliterate;
    }

    private function removeAloneAccents($transliteration)
    {
        return str_replace($this->availableAccents, '', $transliteration);
    }
}
