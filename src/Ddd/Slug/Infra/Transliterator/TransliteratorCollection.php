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
