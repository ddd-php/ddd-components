<?php

namespace Rouffj\Slugify\Tests;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Rouffj\Slugify\Infra\SlugGenerator\AsciiGenerator;
use Rouffj\Slugify\Tests\Fixtures\DoctrineEntity;

class DoctrineAcceptanceTest extends DatabaseTest
{
    public function testDoctrineEntityAsciiTextSlugification()
    {
        $params = array('driver' => 'pdo_sqlite', 'path' => __DIR__.'/Resources/db.sqlite');
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/Fixtures'), true);

        $entity1 = new DoctrineEntity('Hello world!');
        $entity1->slugify(new AsciiGenerator());

        $manager1 = EntityManager::create($params, $config);
        $manager1->persist($entity1);
        $manager1->flush();

        $manager2 = EntityManager::create($params, $config);
        $entity2 = $manager2->find('Rouffj\Slugify\Tests\Fixtures\DoctrineEntity', $entity1->getId());
        $this->assertEquals('hello-world', $entity2->getSlug());
    }
}
