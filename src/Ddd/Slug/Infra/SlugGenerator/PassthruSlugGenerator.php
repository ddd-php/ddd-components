<?php

namespace Ddd\Slug\Infra\SlugGenerator;

use Ddd\Slug\Service\SlugGeneratorInterface;

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
