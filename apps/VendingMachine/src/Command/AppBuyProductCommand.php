<?php
declare(strict_types=1);

namespace VendingMachineCli\Command;


use VendingMachine\Application\BuyProduct\BuyProductCommand;
use VendingMachine\Application\BuyProduct\BuyProductHandler;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VendingMachine\Infrastructure\Repository\JsonFileCashRegisterRepository;
use VendingMachine\Infrastructure\Repository\JsonFileInsertedRepository;
use VendingMachine\Infrastructure\Repository\JsonFileProductsStocksRepository;


final class AppBuyProductCommand extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('buy-product')
            ->setDescription('Buy a product with the coins we inserted.')
            ->addArgument('product', InputArgument::REQUIRED, 'The name of the product: water, juice or soda');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $product = (string)$input->getArgument('product');

        try {
            $command = new BuyProductCommand($product);
            $handler = new BuyProductHandler(
                new JsonFileInsertedRepository(),
                new JsonFileProductsStocksRepository(),
                new JsonFileCashRegisterRepository()
            );
            $result = $handler($command);


            //$result = ($result->isEmpty()) ? 'Not coins inserted' : $result;

            $output->write($result);

        } catch (\Exception $e) {
            $output->write($e->getMessage());
        }

    }

}
