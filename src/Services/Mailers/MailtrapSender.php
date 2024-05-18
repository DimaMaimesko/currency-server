<?php

namespace App\Services\Mailers;

use App\Notifications\NotificationsInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;


class MailtrapSender implements MailerInterface
{
    public function __construct(
        protected TransportInterface $transport,
        protected LoggerInterface $logger
    )
    {
    }

    public function send($to, NotificationsInterface $mail): bool
    {
        $message = (new Email())
            ->from($mail->getFrom())
            ->replyTo($mail->getReplyTo())
            ->to(new Address($to, 'Subscriber'))
            ->priority(Email::PRIORITY_HIGH)
            ->subject($mail->getSubject())
            ->text($mail->getText());

        try {
            $response = $this->transport->send($message);
        } catch (TransportExceptionInterface $e) {
            $this->logger->alert($e->getMessage());
        }

        if ($response instanceof SentMessage) {
            return true;
        } else {
            return false;
        }
    }

}
