<?php

namespace Ddd\Slug\Infra\SlugGenerator;

use Ddd\Slug\Service\SlugGeneratorInterface;
use Ddd\Slug\Service\TransliteratorInterface;

/**
 * Default text slugifier.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class DefaultSlugGenerator implements SlugGeneratorInterface
{
    const REPLACED_CHARS = '~[^a-z0-9]~i';

    /**
     * @var TransliteratorInterface
     */
    private $transliterator;

    /**
     * @var string
     */
    private $wordSeparator;

    /**
     * @var string
     */
    private $fieldSeparator;

    /**
     * @param TransliteratorInterface $transliterator
     * @param string                  $wordSeparator
     * @param string                  $fieldSeparator
     */
    public function __construct(TransliteratorInterface $transliterator, $wordSeparator = '-', $fieldSeparator = '-')
    {
        $this->transliterator = $transliterator;
        $this->wordSeparator = $wordSeparator;
        $this->fieldSeparator = $fieldSeparator;
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues)
    {
        $stringToSlugify = $this->transliterator->transliterate(implode($this->fieldSeparator, $fieldValues));
        $slug = $this->replaceUnwantedChars($stringToSlugify);
        $slug = $this->removeDuplicateWordSeparators($slug);

        return trim(strtolower($slug), $this->wordSeparator);
    }

    /**
     * @param string $stringToSlugify
     *
     * @return string
     */
    private function replaceUnwantedChars($stringToSlugify)
    {
        return preg_replace(self::REPLACED_CHARS, $this->wordSeparator, $stringToSlugify);
    }

    /**
     * @param string $slug
     *
     * @return string
     */
    private function removeDuplicateWordSeparators($slug)
    {
        return preg_replace('~['.preg_quote($this->wordSeparator).']+~', $this->wordSeparator, $slug);
    }
}
