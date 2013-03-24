<?php

namespace Ddd\Slug\Infra\SlugGenerator;

use Ddd\Slug\Service\SlugGeneratorInterface;
use Ddd\Slug\Service\TransliteratorInterface;

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
     * @var TransliteratorInterface[]
     */
    private $transliterators = array();

    /**
     * @var string
     */
    private $options = array(
        'word_separator' => '-',
        'field_separator' => '-',
        'transliterator' => 'latin',
    );

    /**
     * @param TransliteratorInterface $transliterator
     */
    public function __construct(array $transliterators)
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

        if (null === $stringToSlugify = $this->transliterate($fieldValues)) {
            throw new \InvalidArgumentException(sprintf('given transliterator "%s" is not found', $this->options['transliterator']));
        }
        $slug = $this->replaceUnwantedChars($stringToSlugify);
        $slug = $this->removeDuplicateWordSeparators($slug);

        return trim(strtolower($slug), $this->options['word_separator']);
    }

    private function transliterate(array $fieldValues)
    {
        foreach ($this->transliterators as $transliterator) {
            if ($this->options['transliterator'] === $transliterator->getName()) {
                $stringToSlugify = $transliterator->transliterate(implode($this->options['field_separator'], $fieldValues));
            }
        }

        return $stringToSlugify;
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

    public function validateOptions(array $options)
    {
        return true;
    }
}
