Slug: an agnostic slug generator
================================

**Slug** is a component which generates slugs easily whatever persistence
mecanism you use (Propel2, Doctrine2, custom ORM...).

To generate a slug of a string there is always two 2 steps:

- The transliteration step which converts a given string from any writing system
  (French, Deutsh, Greek, Arabic...) into its ASCII representation.
- The slug generation step which basically separates each word and field by a custom delimiter.

Therefore **Slug** component has 2 services: `TransliteratorInterface` and `SlugGeneratorInterface`. Each of these services
can have multiple implementations:

- `LatinTransliterator`: Transliterate a string written in any Latin
  alphabet (French, Deutsh, Spanish...) into its ASCII equivalent.
- `DefaultSlugGenerator`: Customize the word and field separator.
- `PatternSlugGenerator`: Complete customization of slug generation.

Installation
------------

Using Composer, just require the `ddd/components` package:

``` javascript
{
    "require": {
        "ddd/components": "dev-master"
    }
}
```

Usage
-----

To be able to slugify an entity or model, you just have to implement the `SluggableInterface`:

``` php
<?php

use Ddd\Slug\Model\SluggableInterface;
use Ddd\Slug\Service\SlugGeneratorInterface;

class Article implements SluggableInterface
{
    private $createdAt;
    private $title;
    private $slug;

    public function slugify(SlugGeneratorInterface $slugifier)
    {
        $this->slug = $slugifier->slugify(array($this->createdAt->format('Y'), $this->title));
    }

    // other methods...
}
```

Then you just have to call the `slugify` method to generate the slug:

``` php
use Ddd\Slug\Infra\SlugGenerator\DefaultSlugGenerator;
use Ddd\Slug\Infra\Transliterator\LatinTransliterator;

$article = new Article();
$article->setTitle('Hello world!');
$article->slugify(new DefaultSlugGenerator(new LatinTransliterator()));

echo $article->getSlug(); // writes "2013-hello-world"
```

Credits
-------

- Joseph Rouff <rouffj@gmail.com>
- Jean-François Simon <contact@jfsimon.fr>
