<?php

namespace Ddd\Mail\Infra\Mailer;

use Ddd\Mail\Model\Mail;
use Ddd\Mail\Model\Contact;
use Ddd\Mail\Service\MailerInterface;

class SwiftMailer implements MailerInterface
{
    private $mailer;
    private $message;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Mail $mail)
    {
        $recipients = array();
        foreach ($mail->getRecipients() as $contact) {
            $recipients[$contact->getEmail()] = $contact->getName();
        }

        $message = \Swift_Message::newInstance()
            ->setSubject($mail->getSubject())
            ->setFrom(array($mail->getFrom()->getEmail() => $mail->getFrom()->getName()))
            ->setTo($recipients)
        ;

        $this->message = $message;

        $failedRecipients = array();
        $this->mailer->send($message, $failedRecipients);

        $contacts = array();
        foreach ($failedRecipients as $recipient) {
            $contacts[] = new Contact($recipient);
        }

        return $contacts;
    }

    /**
     * Use this method only for testing purpose.
     *
     * @return Swift_Message
     */
    public function getSentMessage()
    {
        return $this->message;
    }
}
