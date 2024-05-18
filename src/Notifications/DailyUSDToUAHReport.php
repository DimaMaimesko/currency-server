<?php

namespace App\Notifications;

use Symfony\Component\Mime\Address;

class DailyUSDToUAHReport implements NotificationsInterface

{
    protected string $subject;
    protected string $text;
    protected string $html;
    protected Address $from;
    protected Address $replyTo;


    public function __construct($rate)
    {
        $this->subject = 'Your daily USD to UAH rate';
        $this->text = "Hi! Today's USD to UAH rate is {$rate}";
        $this->from = new Address('notifications@rates.com', 'Rates Service');
        $this->replyTo = new Address("admin@gmail.com", "Rates Service");
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getFrom(): Address
    {
        return $this->from;
    }

    public function getReplyTo(): Address
    {
        return $this->replyTo;
    }


}
