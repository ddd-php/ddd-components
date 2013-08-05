<?php

namespace Ddd\Mail\Model;

class Attachment
{
    private $path;
    private $mimeType;

    public function __construct($path, $mimeType)
    {
        $this->path = $path;
        $this->mimeType = $mimeType;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function __toString()
    {
        return sprintf("%s", $this->path);
    }
}
