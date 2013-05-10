<?php

namespace Ddd\Mail\Exception;

class MailNotComposedException extends \Exception
{
    public function __construct($message = null)
    {
        $message = $message ?: 'The current mail should have a subject or body';
        parent::__construct($message);
    }
}
