<?php

namespace App\Command;

use App\Services\CurrencyConverter;
use App\Services\HttpClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:get-rate',
    description: 'Add a short description for your command',
)]
class GetRateCommand extends Command
{
    public function __construct(private CurrencyConverter $currencyConverter)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        $result = $this->currencyConverter->rate();
        dd($result);



        return Command::SUCCESS;
    }
}

