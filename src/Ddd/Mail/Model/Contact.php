<?php

namespace Ddd\Mail\Model;

class Contact
{
    private $email;
    private $name;

    public function __construct($email, $name = null)
    {
        $this->email = $email;
        $this->name = $name;
    }
}
