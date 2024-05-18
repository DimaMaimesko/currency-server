<?php

namespace App\Notifications;

use Symfony\Component\Mime\Address;

interface NotificationsInterface
{
    public function getSubject(): string;

    public function getText(): string;
    public function getFrom(): Address;
    public function getReplyTo(): Address;

}
