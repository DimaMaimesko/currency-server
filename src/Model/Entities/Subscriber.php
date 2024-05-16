<?php

namespace App\Model\Entities;


use App\Model\Entities\Email;

class Subscriber
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Email
     */
    private $email;
    /**
     * @var \DateTimeImmutable
     */
    private $date;


}
