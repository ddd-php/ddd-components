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
    private $separator;

    /**
     * @param string $separator
     */
    public function __construct($separator = '')
    {
        $this->separator = $separator;
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $values)
    {
        return implode($this->separator, $values);
    }
}
