<?php

namespace Chris\Bundle\MailBundle\Mailer;

use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;

class SwiftMailer implements MailerInterface
{
    /**
     * @var Swift_Mailer $swiftMailer
     */
    protected $swiftMailer;

    /**
     * @var Swift_Message $mail
     */
    protected $mail;

    /**
     * @param Swift_Mailer $swiftMailer
     */
    public function __construct(Swift_Mailer $swiftMailer)
    {
        $this->swiftMailer = $swiftMailer;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($from, $fromName, array $to, $subject, $body, array $attachments = [], array $options = [])
    {
        $this->mail = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setBody($body, 'text/html');

        foreach ($to as $receiver) {
            $this->mail->addTo($receiver);
        }

        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->mail->attach(Swift_Attachment::fromPath($attachment));
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        if (null !== $this->mail) {
            $this->swiftMailer->send($this->mail);
        }
    }
}
