<?php

namespace App\Services\Mailers;

use App\Notifications\NotificationsInterface;

interface MailerInterface
{
    public function send(string $email, NotificationsInterface $mail): bool;

}
