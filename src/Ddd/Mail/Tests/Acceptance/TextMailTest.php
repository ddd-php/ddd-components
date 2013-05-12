<?php

namespace Ddd\Mail\Tests\Acceptance;

use Ddd\Mail\Model\TextMail;
use Ddd\Mail\Model\Contact;
use Ddd\Mail\Infra\Mailer\SwiftMailer;
use Ddd\Mail\Infra\Mailer\AmazonSesMailer;
use Ddd\Mail\Exception\MailNotComposedException;
use Ddd\Mail\Exception\MailWithoutRecipientException;

class TextMailTest extends \PhpUnit_Framework_TestCase
{
    private $mail;

    public function setUp()
    {
        $this->mail = new TextMail(new Contact('rouffj@gmail.com'));
    }

    public function testWhenSuccessfullySentWithSwiftMailer()
    {
        $swiftMailer = $this->getMock('Swift_Mailer', array(), array(), '', false);
        $this->mail->compose('Subject', 'Here is the body');
        $this->mail->addRecipient(new Contact('foo@bar.com', 'Foo Bar'));

        $swiftMailer->expects($this->once())->method('send');
        $this->mail->send($mailer = new SwiftMailer($swiftMailer));

        $msg = $mailer->getSentMessage();
        $this->assertEquals('Subject', $msg->getSubject());
        $this->assertEquals('Here is the body', $msg->getBody());
        $this->assertEquals(array('foo@bar.com' => 'Foo Bar'), $msg->getTo());
        $this->assertEquals(array('rouffj@gmail.com' => null), $msg->getFrom());
        $this->assertEquals('text/plain', $msg->getContentType());
        $this->assertEquals('utf-8', $msg->getCharset());
        $this->assertEquals(array(), $this->mail->getFailedRecipients());
    }

    public function testWhenSuccessfullySentWithSesAmazon()
    {
        $amazonMailer = $this->getMock('Aws\Ses\SesClient', array(), array(), '', false);
        $command = $this->getMock('Guzzle\Service\Command\CommandInterface', array(), array(), '', false);
        $this->mail->compose('Subject', 'Here is the body');
        $this->mail->addRecipient(new Contact('foo@bar.com', 'Foo Bar'));

        $command->expects($this->once())->method('execute');
        $amazonMailer->expects($this->once())->method('getCommand')->will($this->returnValue($command));
        $this->mail->send($mailer = new AmazonSesMailer($amazonMailer));

        $msg = $mailer->getSentMessage();
        $this->assertEquals($this->mail->getSubject(), $msg['Message']['Subject']['Data']);
        $this->assertEquals($this->mail->getBody(), $msg['Message']['Body']['Text']['Data']);
        $this->assertEquals($this->mail->getFrom()->toString(), $msg['Source']);
        $this->assertEquals(array('foo@bar.com'), $msg['Destination']['ToAddresses']);
        $this->assertEquals('utf-8', $msg['Message']['Subject']['Charset']);
        $this->assertEquals('utf-8', $msg['Message']['Body']['Text']['Charset']);
    }

    public function testWhenFailedSentWithSwiftMailer()
    {
        $swiftMailer = $this->getMock('Swift_Mailer', array(), array(), '', false);
        $this->mail->compose('Subject', null);
        $this->mail->addRecipient(new Contact('foo@bar.com', 'Foo Bar'));

        $swiftMailer->expects($this->once())->method('send')->will($this->returnCallback(function($message, &$failedRecipients) {
            $failedRecipients = array('foo@bar.com');
        }));
        $this->mail->send($mailer = new SwiftMailer($swiftMailer));

        $msg = $mailer->getSentMessage();
        $this->assertEquals(array(new Contact('foo@bar.com')), $this->mail->getFailedRecipients());
    }
}
