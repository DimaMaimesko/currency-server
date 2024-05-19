<?php

namespace App\Scheduler\Handler;

use App\Model\Entities\Subscriber;
use App\Repository\SubscribersRepository;
use App\Scheduler\Message\SendDailyRatesReports;
use App\Services\CurrencyConvertors\FixerConverter;
use App\Services\CurrencyConvertors\NBUConverter;
use App\Services\Mailers\MailtrapSender;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SendDailyRatesReportsHandlerTest extends TestCase
{
    private SubscribersRepository|MockObject $subscribersRepository;
    private Logger|MockObject $logger;
    private EntityManagerInterface|MockObject $entityManager;
    private MailtrapSender|MockObject $sender;
    private NBUConverter|MockObject $nbuConverter;
    private FixerConverter|MockObject $fixerConverter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subscribersRepository = $this->getMockBuilder(SubscribersRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
        $this->entityManager->method('getRepository')
            ->willReturn($this->subscribersRepository);
        $this->logger = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->sender = $this->getMockBuilder(MailtrapSender::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->nbuConverter = $this->createMock(NBUConverter::class);
        $this->nbuConverter->method('rate')
            ->with($this->equalTo(1), $this->equalTo('USD'), $this->equalTo('UAH'));
        $this->fixerConverter = $this->createMock(FixerConverter::class);
        $this->fixerConverter->method('rate')
            ->with($this->equalTo(1), $this->equalTo('USD'), $this->equalTo('UAH'));
    }

    public function testSuccess()
    {
        $this->subscribersRepository->expects($this->once())
            ->method('all')
            ->willReturn([$subscriber1 = new Subscriber(), $subscriber2 = new Subscriber()]);
        $this->sender->expects($this->exactly(2))
            ->method('send');
        $handler = new SendDailyRatesReportsHandler(
            $this->logger,
            $this->entityManager,
            $this->sender,
            $this->nbuConverter,
            $this->fixerConverter,
        );
        $handler(new SendDailyRatesReports(1,'USD', 'UAH'));
    }

    public function testSubscribersNotFound()
    {
        $this->subscribersRepository->expects($this->once())
            ->method('all')
            ->willReturn([]);

        $handler = new SendDailyRatesReportsHandler(
            $this->logger,
            $this->entityManager,
            $this->sender,
            $this->nbuConverter,
            $this->fixerConverter,
        );
        $handler(new SendDailyRatesReports(1,'USD', 'UAH'));
    }

}
