<?php

namespace Ddd\Mail\Exception;

class MailWithoutRecipientException extends \Exception
{
    public function __construct($message = null)
    {
        $message = $message ?: "A mail should have at least one recipient to be sent";
        parent::__construct($message);
    }
}
