<?php

namespace Rouffj\Slugify\Tests;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Rouffj\Slugify\Tests\Fixtures\InMemoryArticle;
use Rouffj\Slugify\Tests\Fixtures\DoctrineArticle;
use Rouffj\Slugify\Infra\SlugGenerator\DefaultSlugGenerator;
use Rouffj\Slugify\Infra\SlugGenerator\PassthruSlugGenerator;
use Rouffj\Slugify\Infra\Transliterator\LatinTransliterator;
use Rouffj\Slugify\Infra\Transliterator\PassthruTransliterator;

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

    /** @dataProvider getEntityAsciiTextPropertySlugificationTestData */
    public function testEntityAsciiTextSlugification($title, $slug)
    {
        $article = new InMemoryArticle();
        $article->setTitle($title);
        $article->slugify(new DefaultSlugGenerator(new PassthruTransliterator()));
        $this->assertEquals($slug, $article->getSlug());
    }

    public function testICouldUseSlugifyWithDoctrineOrm()
    {
        $this->backupDatabase();

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
        $loadedArticle = $em2->find('Rouffj\Slugify\Tests\Fixtures\DoctrineArticle', $persistedArticle->getId());
        $this->assertEquals('hello-world', $loadedArticle->getSlug());

        $this->restoreDatabase();
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

    private function backupDatabase()
    {
        copy(__DIR__.'/Resources/db.sqlite', __DIR__.'/Resources/db.backup');
    }

    private function restoreDatabase()
    {
        rename(__DIR__.'/Resources/db.backup', __DIR__.'/Resources/db.sqlite');
    }

    /** @dataProvider getLatinTransliterationData */
    public function testLatinTransliteration($original, $transliterated)
    {
        $transliterator = new LatinTransliterator();
        $this->assertEquals($transliterated, $transliterator->transliterate($original));
    }

    /** @dataProvider getLatinTransliterationData */
    public function testEntityLatinTransliteratedSlugification($title, $slug)
    {
        $entity = new InMemoryArticle($title);
        $entity->slugify(new DefaultSlugGenerator(new LatinTransliterator()));
        $this->assertEquals($slug, $entity->getSlug());
    }

    public function getLatinTransliterationData()
    {
        return array(
            array('hello',    'hello'),
            array('étrange',  'etrange'),
            array('habitó',   'habito'),
            array('straße',   'strasse'),
            array('señorita', 'senorita'),
        );
    }
}
