<?php

namespace Ddd\Slugify\Tests;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Ddd\Slugify\Tests\Fixtures\InMemoryArticle;
use Ddd\Slugify\Tests\Fixtures\DoctrineArticle;
use Ddd\Slugify\Infra\SlugGenerator\DefaultSlugGenerator;
use Ddd\Slugify\Infra\SlugGenerator\PassthruSlugGenerator;
use Ddd\Slugify\Infra\Transliterator\LatinTransliterator;
use Ddd\Slugify\Infra\Transliterator\PassthruTransliterator;

class AcceptanceTest extends \PhpUnit_Framework_TestCase
{
    public function testEntityPassthruSlugification()
    {
        $title = 'Hello slugifier!';
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify(new PassthruSlugGenerator());
        $this->assertEquals($title, $article->getSlug());
    }

    /** @dataProvider Ddd\Slugify\Tests\AcceptanceDataProvider::getEntityAsciiTextSlugificationData */
    public function testEntityAsciiTextSlugification($title, $slug)
    {
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify(new DefaultSlugGenerator(new PassthruTransliterator()));
        $this->assertEquals($slug, $article->getSlug());
    }

    /** @dataProvider Ddd\Slugify\Tests\AcceptanceDataProvider::getEntityLatinTransliteratedSlugificationData */
    public function testEntityLatinTransliteratedSlugification($title, $slug)
    {
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify(new DefaultSlugGenerator(new LatinTransliterator()));
        $this->assertEquals($slug, $article->getSlug());
    }

    public function testICouldUseSlugifyWithDoctrineOrm()
    {
        TestDatabase::backup();

        // Doctrine setup
        $params = array('driver' => 'pdo_sqlite', 'path' => __DIR__.'/Resources/db.sqlite');
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/Fixtures'), true);
        $em1 = EntityManager::create($params, $config);
        $em2 = EntityManager::create($params, $config);

        // Create a new entity which should be slugified
        $persistedArticle = new DoctrineArticle();
        $persistedArticle->setTitle('Hello world!');
        $persistedArticle->slugify(new DefaultSlugGenerator(new PassthruTransliterator()));

        // Store into database slugified entity
        $em1->persist($persistedArticle);
        $em1->flush();

        // Retrieve entity from database
        $loadedArticle = $em2->find('Ddd\Slugify\Tests\Fixtures\DoctrineArticle', $persistedArticle->getId());
        $this->assertEquals('hello-world', $loadedArticle->getSlug());

        TestDatabase::restore();
    }
}
