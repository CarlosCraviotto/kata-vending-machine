<?php
declare(strict_types=1);

namespace VendingMachineCli\Command;



use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VendingMachine\Application\ReturnCoins\ReturnCoinsHandler;
use VendingMachine\Application\ReturnCoins\ReturnCoinsQuery;
use VendingMachine\Infrastructure\Repository\JsonFileInsertedRepository;


final class AppReturnCoinCommand extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('return-coins')
            ->setDescription('Return all the coins we inserted.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {

        try {
            $command = new ReturnCoinsQuery();
            $handler = new ReturnCoinsHandler(new JsonFileInsertedRepository());
            $result = $handler($command);

            $result = ($result->isEmpty()) ? 'Not coins inserted' : $result;

            $output->write($result);

        } catch (\Exception $e) {
            $output->write($e->getMessage());
        }

    }

}
