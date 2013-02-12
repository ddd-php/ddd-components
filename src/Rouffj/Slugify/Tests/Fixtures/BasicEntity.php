<?php

namespace Rouffj\Slugify\Tests\Fixtures;

use Rouffj\Slugify\Service\SlugGeneratorInterface;
use Rouffj\Slugify\Model\SluggableInterface;

class BasicEntity implements SluggableInterface
{
    private $title;
    private $slug;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function slugify(SlugGeneratorInterface $slugifier)
    {
        $this->slug = $slugifier->slugify(array($this->title));
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
