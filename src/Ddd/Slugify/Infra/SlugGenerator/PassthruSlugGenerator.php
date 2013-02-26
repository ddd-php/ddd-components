<?php

namespace Ddd\Slugify\Infra\SlugGenerator;

use Ddd\Slugify\Service\SlugGeneratorInterface;

/**
 * Passthru slugifier returning joined values.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class PassthruSlugGenerator implements SlugGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues)
    {
        return implode('', $fieldValues);
    }
}
