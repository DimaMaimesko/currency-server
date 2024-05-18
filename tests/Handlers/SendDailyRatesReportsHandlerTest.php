<?php

namespace App\Scheduler\Handler;

use App\Model\Entities\Subscriber;
use App\Repository\SubscribersRepository;
use App\Scheduler\Message\SendDailyRatesReports;
use App\Services\CurrencyConvertors\FixerConverter;
use App\Services\CurrencyConvertors\NBUConverter;
use App\Services\Mailers\MailtrapSender;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


class SendDailyRatesReportsHandlerTest extends TestCase
{

    private Logger|MockObject $logger;

    private SubscribersRepository|MockObject $subscribersRepository;

    private MailtrapSender|MockObject $sender;
    private NBUConverter|MockObject $nbuConverter;
    private FixerConverter|MockObject $fixerConverter;
    private SendDailyRatesReportsHandler|MockObject $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->subscribersRepository = $this->getMockBuilder(SubscribersRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->sender = $this->getMockBuilder(MailtrapSender::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->nbuConverter = $this->getMockBuilder(NBUConverter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->fixerConverter = $this->getMockBuilder(FixerConverter::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            $this->subscribersRepository,
            $this->sender,
            $this->nbuConverter,
            $this->fixerConverter,
        );
        $handler(new SendDailyRatesReports());
    }

    public function testSubscribersNotFound()
    {
        $this->subscribersRepository->expects($this->once())
            ->method('all')
            ->willReturn([]);
        $this->logger->expects($this->once())
            ->method('info')
            ->with('No subscribers found.');

        $handler = new SendDailyRatesReportsHandler(
            $this->logger,
            $this->subscribersRepository,
            $this->sender,
            $this->nbuConverter,
            $this->fixerConverter,
        );
        $handler(new SendDailyRatesReports());
    }
}
