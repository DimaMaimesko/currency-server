<?php

namespace App\Controller;

use App\Notifications\DailyUSDToUAHReport;
use App\Services\Mailers\MailtrapSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class SenderTestController extends AbstractController
{
    private TransportInterface $transport;

    public function __construct(
        TransportInterface $transport,
        protected MailtrapSender $sender)
    {
        $this->transport = $transport;
    }

    #[Route('/test', name: 'test', methods: ['GET'])]
    public function sendTestEmail(): JsonResponse
    {

        $this->sender->send(
            to: 'dima.maimesko@gmail.com',
            mail: new DailyUSDToUAHReport('45.56')
        );

        return $this->json('Test email sent!');
    }
}
