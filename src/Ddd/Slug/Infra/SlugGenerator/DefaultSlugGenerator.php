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
    private $defaultOptions = array(
        'word_separator'  => '-',
        'field_separator' => '-',
        'transliterator'  => 'latin',
    );

    /**
     * @param TransliteratorCollection $transliterators
     */
    public function __construct(TransliteratorCollection $transliterators)
    {
        $this->transliterators = $transliterators;
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

        $transliteratedValues = $this->transliterate($fieldValues, $options['transliterator']);
        $stringToSlugify = implode($options['field_separator'], $transliteratedValues);

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
     * @param array  $fieldValues
     * @param string $transliteratorName
     * @return array
     */
    private function transliterate(array $fieldValues, $transliteratorName)
    {
        $transliterators = $this->transliterators;

        return array_map(function ($fieldValue) use ($transliterators, $transliteratorName) {
            return $transliterators->transliterate($transliteratorName, $fieldValue);
        }, $fieldValues);
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
