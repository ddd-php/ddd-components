<?php

namespace Ddd\Mail\Model;

use Ddd\Mail\Exception\MailNotComposedException;
use Ddd\Mail\Exception\MailWithoutRecipientException;
use Ddd\Mail\Service\MailerInterface;

abstract class Mail
{
    private $subject;
    private $body;
    private $recipients = array();
    private $failedRecipients = array();
    private $sent = false;

    public function __construct(Contact $from)
    {
        $this->from = $from;
    }

    public function compose($subject, $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    public function addRecipient(Contact $recipient)
    {
        $this->recipients[] = $recipient;
    }

    public function send(MailerInterface $mailer)
    {
        if (null === $this->subject && null === $this->body) {
            throw new MailNotComposedException();
        }

        if (0 === count($this->recipients)) {
            throw new MailWithoutRecipientException();
        }

        $this->failedRecipients = $mailer->send($this);
        if (0 === count($this->failedRecipients)) {
            $this->sent = true;
        }
    }

    public function isSent()
    {
        return $this->sent;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getFailedRecipients()
    {
        return $this->failedRecipients;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getBody()
    {
        return $this->body;
    }
}
