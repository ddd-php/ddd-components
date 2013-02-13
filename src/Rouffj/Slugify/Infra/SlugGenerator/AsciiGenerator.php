<?php

namespace Rouffj\Slugify\Infra\SlugGenerator;

/**
 * Ascii text slugifier.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class AsciiGenerator extends PassthruGenerator
{
    const REPLACED_CHARS = '~[^a-z0-9]~i';

    /**
     * @var string
     */
    private $wordSeparator;

    /**
     * @param string $wordSeparator
     * @param string $fieldSeparator
     */
    public function __construct($wordSeparator = '-', $fieldSeparator = '-')
    {
        $this->wordSeparator = $wordSeparator;
        parent::__construct($fieldSeparator);
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues)
    {
        $slug = $this->replaceUnwantedChars(parent::slugify($fieldValues));
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
