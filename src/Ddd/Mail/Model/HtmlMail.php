<?php

namespace Ddd\Mail\Model;

class HtmlMail extends Mail
{
    private $altText;
    private $attachments = array();

    public function compose($subject, $body)
    {
        $this->altText = strip_tags($body);

        return parent::compose($subject, $body);
    }

    public function getAltText()
    {
        return $this->altText;
    }

    public function addAttachment(Attachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }
}
