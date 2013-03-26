<?php

namespace Ddd\Slug\Tests;

use Ddd\Slug\Infra\Transliterator\TransliteratorCollection;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Ddd\Slug\Tests\Fixtures\InMemoryArticle;
use Ddd\Slug\Tests\Fixtures\DoctrineArticle;
use Ddd\Slug\Infra\SlugGenerator\DefaultSlugGenerator;
use Ddd\Slug\Infra\SlugGenerator\PassthruSlugGenerator;
use Ddd\Slug\Infra\Transliterator\LatinTransliterator;
use Ddd\Slug\Infra\Transliterator\PassthruTransliterator;

class AcceptanceTest extends \PhpUnit_Framework_TestCase
{
    private $defaultSlugGenerator;
    private $passthruSlugGenerator;

    protected function setUp()
    {
        $transliterators = new TransliteratorCollection(array(new PassthruTransliterator(), new LatinTransliterator()));
        $this->defaultSlugGenerator = new DefaultSlugGenerator($transliterators);
        $this->passthruSlugGenerator = new PassthruSlugGenerator();
    }

    public function testEntityPassthruSlugification()
    {
        $title = 'Héllo slugifier!';
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify($this->passthruSlugGenerator);
        $this->assertEquals($title, $article->getSlug());
    }

    /** @dataProvider Ddd\Slug\Tests\AcceptanceDataProvider::getEntityAsciiTextSlugificationData */
    public function testEntityAsciiTextSlugification($title, $slug)
    {
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify($this->defaultSlugGenerator);
        $this->assertEquals($slug, $article->getSlug());
    }

    /** @dataProvider Ddd\Slug\Tests\AcceptanceDataProvider::getEntityLatinTransliteratedSlugificationData */
    public function testEntityLatinTransliteratedSlugification($title, $slug)
    {
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify($this->defaultSlugGenerator);
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
        $persistedArticle->slugify($this->defaultSlugGenerator);

        // Store into database slugified entity
        $em1->persist($persistedArticle);
        $em1->flush();

        // Retrieve entity from database
        $loadedArticle = $em2->find('Ddd\Slug\Tests\Fixtures\DoctrineArticle', $persistedArticle->getId());
        $this->assertEquals('hello-world', $loadedArticle->getSlug());

        TestDatabase::restore();
    }
}
