<?php
declare(strict_types=1);

namespace VendingMachine\Application\ReturnCoins;

use VendingMachine\Application\ReturnCoins\ReturnCoinsQuery;
use VendingMachine\Domain\Coin\CoinFactory;
use VendingMachine\Domain\Inserted\InsertedRepository;
use VendingMachine\Infrastructure\Repository\JsonFileInsertedRepository;

final class ReturnCoinsHandler
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

    public function __invoke(ReturnCoinsQuery $query): ReturnCoinsResult
    {
        $useCase = new ReturnCoinsUseCase($this->repository);
        return $useCase->returnCoins();
    }
}