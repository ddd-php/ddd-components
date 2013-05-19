<?php

namespace Ddd\Mail\Tests\Acceptance;

use Ddd\Mail\MailBuilder;
use Ddd\Mail\Model\TextMail;
use Ddd\Mail\Model\Contact;

/**
 * Feature: simplify even more mail creation
 */
class MailBuilderTest extends \PhpUnit_Framework_TestCase
{
    public function testWhenBuildingTextMail()
    {
        $builder = MailBuilder::create('sender@foo.bar', 'John Doo')
            ->addRecipients(array(
                'recipient1@bar.com',
                'recipient2@bar.com' => 'Recipient 2',
                'recipient3@bar.com',
            ))
            ->compose('My subject', 'My body')
        ;

        $mail = $builder->getTextMail();

        $expectedMail = new TextMail(new Contact('sender@foo.bar', 'John Doo'));
        $expectedMail
            ->addRecipient(new Contact('recipient1@bar.com'))
            ->addRecipient(new Contact('recipient2@bar.com', 'Recipient 2'))
            ->addRecipient(new Contact('recipient3@bar.com'))
            ->compose('My subject', 'My body')
        ;
        $this->assertEquals($expectedMail, $mail);
    }
}
