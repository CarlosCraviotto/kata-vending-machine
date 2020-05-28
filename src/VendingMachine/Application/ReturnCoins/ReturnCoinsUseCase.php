<?php
declare(strict_types=1);

namespace VendingMachine\Application\ReturnCoins;


use VendingMachine\Domain\Inserted\InsertedRepository;

final class ReturnCoinsUseCase
{
    private $repository;

    /**
     * InsertCoinUseCase constructor.
     * @param $repository
     */
    public function __construct(InsertedRepository $repository)
    {
        $this->repository = $repository;
    }

    public function returnCoins(): ReturnCoinsResult
    {
        $inserted = $this->repository->loadInserted();
        $coins = $inserted->returnCoins();
        $this->repository->saveInserted($inserted);
        return new ReturnCoinsResult($coins);
    }
}