<?php

namespace Ddd\Mail\Infra\Mailer;

use Ddd\Mail\Model\Mail;
use Ddd\Mail\Model\TextMail;
use Ddd\Mail\Model\Contact;
use Ddd\Mail\Service\MailerInterface;
use Aws\Ses\SesClient;

class AmazonSesMailer implements MailerInterface
{
    private $mailer;
    private $message;

    public function __construct(SesClient $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Mail $mail)
    {
        $amazonSesMessage = $this->transform($mail);

        $this->mailer->getCommand('SendEmail', $amazonSesMessage)->execute();
        $this->message = $amazonSesMessage;
    }

    private function transform(Mail $mail)
    {
        $recipients = array();
        foreach ($mail->getRecipients() as $contact) {
            $recipients[$contact->getEmail()] = $contact->getName();
        }

        $message = array(
            'Source' => $mail->getFrom()->toString(),
            'Destination' => array(
                'ToAddresses' => array_keys($recipients)
            ),
            'Message' => array(
                'Subject' => array(
                    'Data' => $mail->getSubject(),
                    'Charset' => $mail->getCharset(),
                ),
                'Body' => array(
                    'Text' => array(
                        'Data' => $mail->getBody(),
                        'Charset' => $mail->getCharset(),
                    ),
                ),
            ),
        );

        return $message;
    }

    /**
     * Use this method only for testing purpose.
     *
     * @return Array
     */
    public function getSentMessage()
    {
        return $this->message;
    }
}
