<?php

namespace Ddd\Mail\Infra\Mailer;

use Ddd\Mail\Model\Mail;
use Ddd\Mail\Service\MailerInterface;

class NullMailer implements MailerInterface
{
    private $sent;

    public function __construct($sent = true)
    {
        $this->sent = $sent;
    }

    public function send(Mail $mail)
    {
        return $this->sent ? array() : $mail->getRecipients();
    }
}
