<?php

namespace Ddd\Slug\Infra\Transliterator;

use Ddd\Slug\Service\TransliteratorInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class TransliteratorCollection
{
    /**
     * @var TransliteratorInterface[]
     */
    private $transliterators = array();

    /**
     * @param TransliteratorInterface[] $transliterators
     */
    public function __construct(array $transliterators)
    {
        foreach ($transliterators as $transliterator) {
            $this->add($transliterator);
        }
    }

    /**
     * @param TransliteratorInterface $transliterator
     *
     * @return TransliteratorCollection
     */
    public function add(TransliteratorInterface $transliterator)
    {
        $this->transliterators[$transliterator->getName()] = $transliterator;

        return $this;
    }

    /**
     * Transliterates string with named transliterator.
     *
     * @param string $name   Transliterator name
     * @param string $string String to transliterate
     *
     * @throws \InvalidArgumentException If transliterator not found
     *
     * @return string Transliterated string
     */
    public function transliterate($name, $string)
    {
        if (!isset($this->transliterators[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknwon transliterator "%s", known ones are "%s".',
                $name,
                implode('", "', array_keys($this->transliterators))
            ));
        }

        return $this->transliterators[$name]->transliterate($string);
    }

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->transliterators[$name]);
    }

    /**
     * @param string $name
     *
     * @return TransliteratorInterface
     *
     * @throws \InvalidArgumentException
     */
    public function get($name)
    {
        if (!isset($this->transliterators[$name])) {
            throw new \InvalidArgumentException('Transliterator "'.$name.'" does not exist.');
        }

        return $this->transliterators[$name];
    }
}
