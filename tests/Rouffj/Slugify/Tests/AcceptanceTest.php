<?php

namespace Rouffj\Slugify\Tests;

use Rouffj\Slugify\Infra\SlugGenerator\PassthruGenerator;

class AcceptanceTest extends \PhpUnit_Framework_TestCase
{
    public function testEntitySlugificationWithPassthruSlugifier()
    {
        $title = 'Hello slugifier!';
        $entity = new BasicEntity($title);
        $entity->slugify(new PassthruGenerator());
        $this->assertEquals($title, $entity->getSlug());
    }
}
