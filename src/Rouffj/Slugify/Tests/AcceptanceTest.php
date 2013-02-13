<?php

namespace Rouffj\Slugify\Tests;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Rouffj\Slugify\Infra\SlugGenerator\AsciiGenerator;
use Rouffj\Slugify\Infra\SlugGenerator\PassthruGenerator;
use Rouffj\Slugify\Tests\Fixtures\InMemoryArticle;
use Rouffj\Slugify\Tests\Fixtures\DoctrineArticle;

class AcceptanceTest extends \PhpUnit_Framework_TestCase
{
    public function testEntityPassthruSlugification()
    {
        $title = 'Hello slugifier!';
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify(new PassthruGenerator());
        $this->assertEquals($title, $article->getSlug());
    }

    /** @dataProvider getEntityAsciiTextPropertySlugificationTestData */
    public function testEntityAsciiTextSlugification($title, $slug)
    {
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify(new AsciiGenerator());
        $this->assertEquals($slug, $article->getSlug());
    }

    public function testICouldUseSlugifyWithDoctrineOrm()
    {
        // Doctrine setup
        $params = array('driver' => 'pdo_sqlite', 'path' => __DIR__.'/Resources/db.sqlite');
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/Fixtures'), true);
        $em1 = EntityManager::create($params, $config);
        $em2 = EntityManager::create($params, $config);

        // Create a new entity which should be slugified
        $persistedArticle = new DoctrineArticle();
        $persistedArticle->setTitle('Hello world!');
        $persistedArticle->slugify(new AsciiGenerator());

        // Store into database slugified entity
        $em1->persist($persistedArticle);
        $em1->flush();

        // Retrieve entity from database
        $loadedArticle = $em2->find('Rouffj\Slugify\Tests\Fixtures\DoctrineArticle', $persistedArticle->getId());
        $this->assertEquals('hello-world', $loadedArticle->getSlug());
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
