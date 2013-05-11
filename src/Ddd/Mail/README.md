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

Icebox
------

* [x] As a user, I should be able to create a sendable basic email with very simple API.
* [ ] As a user, I should be able to send basic `TextMail` with SwiftMailer as `MailerInterface` implementation.
* [ ] As a user, I could give as recipient a group of contacts.
* [ ] As a user, I could be able to send basic `HtmlEmail` with SwiftMailer.
* [ ] As a user, I could add attachments to `HtmlEmail`.
* [ ] As a user, I could give copy carbon recipient.
* [ ] As a user, I could give blind copy carbon recipient.
* [ ] As a user, a contact should always be valid.
* [ ] As a user, I should be able to change default UTF-8 encoding.
* [ ] As a user, I should be able to send basic `TextMail` with "Amazon SES" as `MailerInterface` implementation.
* [ ] As a user, I should be able to send basic `TextMail` with "Compaign Monitor" as `MailerInterface` implementation.

Credits
-------

- Joseph Rouff <rouffj@gmail.com>
