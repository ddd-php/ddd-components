<?php

namespace Ddd\Mail;

use Ddd\Mail\Model\Contact;
use Ddd\Mail\Model\TextMail;

class MailBuilder
{
    private $from;
    private $recipients = array();
    private $subject;
    private $body;

    public function __construct($senderAddress, $senderName)
    {
        $this->from = new Contact($senderAddress, $senderName);
    }

    public static function create($senderAddress, $senderName)
    {
        return new static($senderAddress, $senderName);
    }

    public function addRecipients(array $recipients)
    {
        foreach ($recipients as $recipientAddress => $recipientName) {
            if (is_int($recipientAddress)) {
				$recipient = new Contact($recipientName, null);
            } else {
				$recipient = new Contact($recipientAddress, $recipientName);
            }

			$this->recipients[$recipient->getEmail()] = $recipient;
        }

        return $this;
    }

    public function compose($subject, $body)
    {
        $this->subject = $subject;
        $this->body = $body;

        return $this;
    }

	public function getTextMail()
	{
		$mail = new TextMail($this->from);
		$mail->compose($this->subject, $this->body);
		foreach ($this->recipients as $recipient) {
			$mail->addRecipient($recipient);
		}

		return $mail;
	}
}
