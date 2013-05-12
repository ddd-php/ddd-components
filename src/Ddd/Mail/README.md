Mail
====

**Mail** is a component which allow to create/send email easily whatever mailer
mecanism you use (SwiftMailer...).

Installation
------------

Using Composer, just require the `ddd/components` package:

``` javascript
{
    "require": {
        "ddd/components": "dev-master"
    }
}
```

Usage
-----

```php
<?php

use Ddd\Mail\Model\TextMail;
use Ddd\Mail\Model\Contact;
use Ddd\Mail\Infra\Mailer\SwiftMailer;

// Prepare your email
$mail = new TextMail(new Contact('support@github.com', 'Github'));
$mail->compose('[Github] Payment receipt', 'Here my body formatted in Text format');
$mail->addRecipient(new Contact('customer@gmail.com'));

// Send it whith the mailer of your choice (SwiftMailer, Amazon SES, Compain monitor...)
$mail->send(new SwiftMailer($container->get('swift_mailer'))); // Send email with SwiftMailer.
$mail->send(new AmazonSesMailer($container->get('aws.ses.client'))); // Send same email with Amazon SES.
```

Icebox
------

* [x] As a user, I should be able to create a sendable basic email with very simple API.
* [x] As a user, I should be able to send basic `TextMail` with SwiftMailer as `MailerInterface` implementation.
* [x] As a user, I should be able to send basic `TextMail` with "Amazon SES" as `MailerInterface` implementation.
* [ ][Chore] As a user, I'm expecting when any error occured, a `MailerException` should be thrown whatever implementation used.
* [ ] As a user, I could give as recipient a group of contacts that will enable "Newsletter" mode.
* [ ] As a user, I could be able to send basic `HtmlEmail` with SwiftMailer.
* [ ] As a user, I could add attachments to `HtmlEmail`.
* [ ] As a user, I could give copy carbon recipient.
* [ ] As a user, I could give blind copy carbon recipient.
* [ ] As a user, a contact should always be valid.
* [ ] As a user, I should be able to change default UTF-8 encoding.
* [ ] As a user, I should be able to send basic `TextMail` with "Compaign Monitor" as `MailerInterface` implementation.
* [ ] As a user, when I put HTML content as body in a `TextMail` the content should be strip of all HTML tags.
* [ ] As a user, when I put HTML content as body in an `HtmlMail` the plain text version should be generated automatically.
* [ ] As a Amazon SES user, I should be able to put special characters in headers (To:, From: etc.).

Credits
-------

- Joseph Rouff <rouffj@gmail.com>
