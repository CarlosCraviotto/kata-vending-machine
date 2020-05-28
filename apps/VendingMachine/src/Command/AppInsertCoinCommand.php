<?php
declare(strict_types=1);

namespace VendingMachineCli\Command;


use VendingMachine\Application\InsertCoin\InsertCoinCommand as InsertCommand;
use VendingMachine\Application\InsertCoin\InsertCoinHandler;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VendingMachine\Infrastructure\Repository\JsonFileInsertedRepository;


final class AppInsertCoinCommand extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('insert-coin')
            ->setDescription('Insert a coin to the machine.')
            ->addArgument('coin', InputArgument::REQUIRED, 'A valid coin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $coin = (float)$input->getArgument('coin');

        try {
            $command = new InsertCommand($coin);
            $handler = new InsertCoinHandler(new JsonFileInsertedRepository());
            $result = $handler($command);

            $message = 'Inserted ' . $coin;

            $output->write($message);

        } catch (\Exception $e) {
            $output->write($e->getMessage());
        }

    }

}
