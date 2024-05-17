<?php

namespace App\Command;

use App\Services\CurrencyConvertors\FixerConverter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

#[AsCommand(
    name: 'app:get-rate-fixer',
    description: 'Add a short description for your command',
)]
class GetRateFixerCommand extends Command
{
    public function __construct(private FixerConverter $currencyConverter, protected ParameterBagInterface $parameterBag)
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
        //dd($this->parameterBag->get('fixer_api_key'));



        return Command::SUCCESS;
    }
}

