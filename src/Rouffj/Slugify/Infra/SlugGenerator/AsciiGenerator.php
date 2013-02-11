<?php

namespace Rouffj\Slugify\Infra\SlugGenerator;

/**
 * Ascii text slugifier.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class AsciiGenerator extends PassthruGenerator
{
    /**
     * @var string
     */
    private $joker;

    /**
     * @param string $joker
     * @param string $separator
     */
    public function __construct($joker = '-', $separator = '-')
    {
        $this->joker = $joker;
        parent::__construct($separator);
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $values)
    {
        $slug = preg_replace('~[^a-z0-9]~i', $this->joker, parent::slugify($values));
        $slug = preg_replace('~['.preg_quote($this->joker).']+~', $this->joker, $slug);

        return trim(strtolower($slug), $this->joker);
    }
}
