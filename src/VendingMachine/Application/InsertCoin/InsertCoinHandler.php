<?php
declare(strict_types=1);

namespace VendingMachine\Application\InsertCoin;

use VendingMachine\Domain\Coin\CoinFactory;
use VendingMachine\Domain\Inserted\InsertedRepository;
use VendingMachine\Infrastructure\Repository\JsonFileInsertedRepository;

final class InsertCoinHandler
{
    private $repository;

    /**
     * InsertCoinHandler constructor.
     * @param $repository
     */
    public function __construct(InsertedRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(InsertCoinCommand $command): void
    {
        $useCase = new InsertCoinUseCase($this->repository);

        $coin = CoinFactory::buildFromFloat($command->getCoin());

        $useCase->add($coin);
    }
}