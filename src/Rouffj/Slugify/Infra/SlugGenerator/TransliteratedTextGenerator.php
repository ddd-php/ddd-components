<?php

namespace Rouffj\Slugify\Infra\SlugGenerator;

use Rouffj\Slugify\Service\TransliteratorInterface;

/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class TransliteratedTextGenerator extends AsciiGenerator
{
    /**
     * @var TransliteratorInterface
     */
    private $transliterator;

    /**
     * @param TransliteratorInterface $transliterator
     * @param string                  $joker
     * @param string                  $separator
     */
    public function __construct(TransliteratorInterface $transliterator, $joker = '-', $separator = '-')
    {
        $this->transliterator = $transliterator;
        parent::__construct($joker, $separator);
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues)
    {
        return parent::slugify(array_map(array($this->transliterator, 'transliterate'), $fieldValues));
    }
}
