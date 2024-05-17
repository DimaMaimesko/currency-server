<?php

namespace App\Controller\Api;

use App\Model\Entities\Email;
use App\Model\Entities\Subscriber;
use App\Repository\SubscribersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
class SubscribeController extends AbstractController
{
    public function __construct(
        protected SubscribersRepository $subscribersRepository,
    )
    {
    }

    #[Route('/api/subscribe', name: 'subscribe_user', methods: ['POST'])]
    public function subscribe(Request $request): JsonResponse
    {
        $emailFromRequest = $request->request->get("email");
        $email = new Email($emailFromRequest);
        $subscriber = $this->subscribersRepository->findByEmail($email);

        if ($subscriber) {
            return $this->json(['message' => 'Email already subscribed'], 409);
        }

        $subscriber = Subscriber::create($email, new \DateTimeImmutable());

        $this->subscribersRepository->add($subscriber);

        return $this->json(['message' => 'Success!'], 200);
    }


}
