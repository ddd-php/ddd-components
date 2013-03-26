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
    private $options = array(
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
        if (!$this->validateOptions($options)) {
            throw new \InvalidArgumentException('Some of given options are not expected');
        }
        $this->options = array_merge($this->options, $options);

        $transliteratedValues = $this->transliterate($fieldValues);
        $stringToSlugify = implode($this->options['word_separator'], $transliteratedValues);

        $slug = $this->replaceUnwantedChars($stringToSlugify);
        $slug = $this->removeDuplicateWordSeparators($slug);

        return trim(strtolower($slug), $this->options['word_separator']);
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
     * @param array $fieldValues
     *
     * @return array
     */
    private function transliterate(array $fieldValues)
    {
        $transliterators = $this->transliterators;
        $transliteratorName = $this->options['transliterator'];

        return array_map(function ($fieldValue) use ($transliterators, $transliteratorName) {
            return $transliterators->transliterate($transliteratorName, $fieldValue);
        }, $fieldValues);
    }

    /**
     * @param string $stringToSlugify
     *
     * @return string
     */
    private function replaceUnwantedChars($stringToSlugify)
    {
        return preg_replace(self::REPLACED_CHARS, $this->options['word_separator'], $stringToSlugify);
    }

    /**
     * @param string $slug
     *
     * @return string
     */
    private function removeDuplicateWordSeparators($slug)
    {
        return preg_replace('~['.preg_quote($this->options['word_separator']).']+~', $this->options['word_separator'], $slug);
    }
}
