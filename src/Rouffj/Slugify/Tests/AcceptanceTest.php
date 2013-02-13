<?php

namespace Rouffj\Slugify\Tests;

use Rouffj\Slugify\Infra\SlugGenerator\AsciiGenerator;
use Rouffj\Slugify\Infra\SlugGenerator\PassthruGenerator;
use Rouffj\Slugify\Tests\Fixtures\BasicEntity;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Rouffj\Slugify\Tests\Fixtures\DoctrineEntity;

class AcceptanceTest extends \PhpUnit_Framework_TestCase
{
    public function testEntityPassthruSlugification()
    {
        $title = 'Hello slugifier!';
        $entity = new BasicEntity($title);
        $entity->slugify(new PassthruGenerator());
        $this->assertEquals($title, $entity->getSlug());
    }

    /** @dataProvider getEntityAsciiTextPropertySlugificationTestData */
    public function testEntityAsciiTextSlugification($title, $slug)
    {
        $entity = new BasicEntity($title);
        $entity->slugify(new AsciiGenerator());
        $this->assertEquals($slug, $entity->getSlug());
    }

    public function testICouldUseSlugifyWithDoctrineOrm()
    {
        // Doctrine setup
        $params = array('driver' => 'pdo_sqlite', 'path' => __DIR__.'/Resources/db.sqlite');
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/Fixtures'), true);
        $em1 = EntityManager::create($params, $config);
        $em2 = EntityManager::create($params, $config);

        // Create a new entity which should be slugified
        $entity1 = new DoctrineEntity('Hello world!');
        $entity1->slugify(new AsciiGenerator());

        // Store into database slugified entity
        $em1->persist($entity1);
        $em1->flush();

        // Retrieve entity from database
        $entity2 = $em2->find('Rouffj\Slugify\Tests\Fixtures\DoctrineEntity', $entity1->getId());
        $this->assertEquals('hello-world', $entity2->getSlug());
    }

    public function getEntityAsciiTextPropertySlugificationTestData()
    {
        return array(
            array('    ',             ''),
            array('&&&é---',          ''),
            array('hello world !!',   'hello-world'),
            array('hello      world', 'hello-world'),
            array('AbC',              'abc'),
            array('é&tè!hello_(_',    't-hello'),
        );
    }
}
