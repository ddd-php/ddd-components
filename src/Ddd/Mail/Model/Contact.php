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

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function toString()
    {
        return sprintf("%s <%s>", $this->name, $this->email);
    }
}
