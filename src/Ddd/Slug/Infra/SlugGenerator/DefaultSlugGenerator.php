<?php

namespace Ddd\Slug\Infra\SlugGenerator;

use Ddd\Slug\Infra\Transliterator\TransliteratorCollection;
use Ddd\Slug\Service\SlugGeneratorInterface;

/**
 * Default text slugifier.
 *
 * @author Joseph Rouff <rouffj@gmail.com>
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class DefaultSlugGenerator implements SlugGeneratorInterface
{
    const REPLACED_CHARS = '~[^a-z0-9]~i';

    /**
     * @var TransliteratorCollection
     */
    private $transliterators;

    /**
     * @var array
     */
    private $defaultOptions;

    /**
     * @param TransliteratorCollection $transliterators
     * @param array                    $defaultOptions
     */
    public function __construct(TransliteratorCollection $transliterators, array $defaultOptions)
    {
        $this->transliterators = $transliterators;
        $this->defaultOptions = array_merge(array(
            'word_separator'  => '-',
            'field_separator' => '-',
            'transliterator'  => 'latin',
        ), $defaultOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues, array $options = array())
    {
        $options = array_merge($this->defaultOptions, $options);

        if (!$this->validateOptions($options)) {
            throw new \InvalidArgumentException('Some of given options are not expected');
        }

        $stringToSlugify = $this->transliterators->transliterate($options['transliterator'], implode($options['field_separator'], $fieldValues));
        $slug = $this->replaceUnwantedChars($stringToSlugify, $options['word_separator']);
        $slug = $this->removeDuplicateWordSeparators($slug, $options['word_separator']);

        return trim(strtolower($slug), $options['word_separator']);
    }

    /**
     * @param array $options
     *
     * @return bool
     */
    public function validateOptions(array $options)
    {
        return true;
    }

    /**
     * @param string $stringToSlugify
     * @param string $wordSeparator
     *
     * @return string
     */
    private function replaceUnwantedChars($stringToSlugify, $wordSeparator)
    {
        return preg_replace(self::REPLACED_CHARS, $wordSeparator, $stringToSlugify);
    }

    /**
     * @param string $slug
     * @param string $wordSeparator
     *
     * @return string
     */
    private function removeDuplicateWordSeparators($slug, $wordSeparator)
    {
        return preg_replace('~['.preg_quote($wordSeparator).']+~', $wordSeparator, $slug);
    }
}
