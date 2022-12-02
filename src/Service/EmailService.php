<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private string $subject = '';

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(protected MailerInterface $mailer)
    {
    }

    /**
     * @return bool
     */
    public function send(): bool
    {
        $email = new Email();

        $email->subject($this->getSubject())
            ->text($this->getSubject())
            ->to();
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

}
