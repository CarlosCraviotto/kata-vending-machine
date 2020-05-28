<?php
declare(strict_types=1);

namespace VendingMachineCli\Command;



use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use VendingMachine\Application\SetService\SetServiceCommand;
use VendingMachine\Application\SetService\SetServiceHandler;
use VendingMachine\Infrastructure\Repository\JsonFileCashRegisterRepository;
use VendingMachine\Infrastructure\Repository\JsonFileProductsStocksRepository;


final class AppSetServiceCommand extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('set-service')
            ->setDescription('Set the available products/change.')
            ->addArgument('type', InputArgument::REQUIRED, 'The type of the data (products/change)')
            ->addArgument('data', InputArgument::REQUIRED, 'The data in json format ([["juice",10],["water",10],["soda",9]])');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $type = (string)$input->getArgument('type');
        $data = $input->getArgument('data');

        try {
            $command = new SetServiceCommand($type, $data);
            $handler = new SetServiceHandler(
                new JsonFileProductsStocksRepository(),
                new JsonFileCashRegisterRepository()
            );

            $handler($command);


            $output->write("Done!");

        } catch (\Exception $e) {
            $output->write($e->getMessage());
        }

    }

}
