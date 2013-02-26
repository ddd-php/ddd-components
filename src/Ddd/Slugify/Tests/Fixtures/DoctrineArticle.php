<?php

namespace Ddd\Slugify\Tests\Fixtures;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

use Ddd\Slugify\Model\SluggableInterface;
use Ddd\Slugify\Service\SlugGeneratorInterface;

/** @Entity @Table(name="entity") */
class DoctrineArticle implements SluggableInterface
{
    /** @Column(type="integer") @GeneratedValue @Id */
    private $id;

    /** @Column(type="string") */
    private $title;

    /** @Column(type="string") */
    private $slug;

    public function getId()
    {
        return $this->id;
    }

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
