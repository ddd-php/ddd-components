<?php

namespace Ddd\Mail\Model;

class Attachment
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function __toString()
    {
        return sprintf("%s", $this->path);
    }
}
