<?php

namespace Ddd\Slugify\Tests\Fixtures;

use Ddd\Slugify\Service\SlugGeneratorInterface;
use Ddd\Slugify\Model\SluggableInterface;

class InMemoryArticle implements SluggableInterface
{
    private $title;
    private $slug;

    public function slugify(SlugGeneratorInterface $slugifier)
    {
        $this->slug = $slugifier->slugify(array($this->title));
    }

    public function setTitle($title)
    {
        $this->title = $title;
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
