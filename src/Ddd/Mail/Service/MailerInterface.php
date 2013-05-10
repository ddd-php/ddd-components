<?php

namespace Ddd\Mail\Service;

use Ddd\Mail\Model\Mail;

interface MailerInterface
{
    public function send(Mail $mail);
}
