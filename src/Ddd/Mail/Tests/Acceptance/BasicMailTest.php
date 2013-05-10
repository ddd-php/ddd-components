<?php

namespace Ddd\Mail\Tests\Acceptance;

use Ddd\Mail\Model\TextMail;
use Ddd\Mail\Model\Contact;
use Ddd\Mail\Infra\Mailer\NullMailer;
use Ddd\Mail\Exception\MailNotComposedException;
use Ddd\Mail\Exception\MailWithoutRecipientException;

class BasicMailTest extends \PhpUnit_Framework_TestCase
{
    private $mail;

    public function setUp()
    {
        $this->mail = new TextMail(new Contact('rouffj@gmail.com'));
    }

    public function testWhenNewMail()
    {
        $mail = new TextMail($from = new Contact('foo@bar.com'));

        $this->assertNull($mail->getSubject());
        $this->assertNull($mail->getBody());
        $this->assertEquals($from, $mail->getFrom());
        $this->assertFalse($mail->isSent());
        $this->assertEquals(array(), $mail->getFailedRecipients());
        $this->assertEquals(array(), $mail->getRecipients());
    }

    public function testSendWhenMailNotComposed()
    {
        try {
            $this->mail->send(new NullMailer);
            $this->fail('An exception should be thrown because neither subject nor body filled in');
        } catch(MailNotComposedException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSendWhenMailComposedWithNullValue()
    {
        $this->mail->compose(null, null);

        try {
            $this->mail->send(new NullMailer);
            $this->fail('An exception should be thrown because neither subject nor body filled in');
        } catch(MailNotComposedException $e) {
            $this->assertTrue(true);
        }
    }

    public function testComposeWhenTextGiven()
    {
        $this->mail->compose('My subject', 'My body');

        $this->assertEquals('My subject', $this->mail->getSubject());
        $this->assertEquals('My body', $this->mail->getBody());
    }

    public function testSendWhenMailWithoutRecipient()
    {
        $this->mail->compose('My subject', null);

        try {
            $this->mail->send(new NullMailer);
            $this->fail('An exception should be thrown because no recipient added');
        } catch(MailWithoutRecipientException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSendWhenMailSent()
    {
        $this->mail->compose('My subject', null);
        $this->mail->addRecipient(new Contact('rouffj@gmail.com'));

        $this->mail->send(new NullMailer);

        $this->assertEquals(array(), $this->mail->getFailedRecipients());
        $this->assertEquals(true, $this->mail->isSent());
    }

    public function testSendWhenMailNotSent()
    {
        $this->mail->compose('My subject', null);
        $this->mail->addRecipient($contact = new Contact('rouffj@gmail.com'));

        $this->mail->send(new NullMailer(false));

        $this->assertEquals(array($contact), $this->mail->getFailedRecipients());
        $this->assertEquals(false, $this->mail->isSent());
    }
}
