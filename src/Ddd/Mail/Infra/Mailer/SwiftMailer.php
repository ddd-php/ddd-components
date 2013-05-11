<?php

namespace Ddd\Mail\Infra\Mailer;

use Ddd\Mail\Model\Mail;
use Ddd\Mail\Model\TextMail;
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
        $swiftMessage = $this->transform($mail);

        $failedRecipients = array();
        $this->mailer->send($swiftMessage, $failedRecipients);
        $this->message = $swiftMessage;

        $contacts = array();
        foreach ($failedRecipients as $recipient) {
            $contacts[] = new Contact($recipient);
        }

        return $contacts;
    }

    private function transform(Mail $mail)
    {
        $recipients = array();
        foreach ($mail->getRecipients() as $contact) {
            $recipients[$contact->getEmail()] = $contact->getName();
        }

        $message = \Swift_Message::newInstance()
            ->setCharset($mail->getCharset())
            ->setFrom(array($mail->getFrom()->getEmail() => $mail->getFrom()->getName()))
            ->setTo($recipients)
            ->setSubject($mail->getSubject())
            ->setBody($mail->getBody())
        ;

        $contentType = ($mail instanceof TextMail) ? 'text/plain' : 'text/html';
        $message->setContentType($contentType);

        return $message;
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
