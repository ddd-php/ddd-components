<?php

namespace Rouffj\Slugify\Infra\SlugGenerator;

use Rouffj\Slugify\Service\SlugGeneratorInterface;

/**
 * Passthru slugifier returning joined values.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class PassthruGenerator implements SlugGeneratorInterface
{
    /**
     * @var string
     */
    private $fieldSeparator;

    /**
     * @param string $fieldSeparator
     */
    public function __construct($fieldSeparator = '-')
    {
        $this->fieldSeparator = $fieldSeparator;
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues)
    {
        $slug = implode($this->fieldSeparator, $fieldValues);

        return trim($slug, $this->fieldSeparator);
    }
}
