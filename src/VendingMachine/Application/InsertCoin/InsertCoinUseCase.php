<?php
declare(strict_types=1);

namespace VendingMachine\Application\InsertCoin;

use VendingMachine\Domain\Coin\Coin;

use VendingMachine\Domain\Inserted\InsertedRepository;

final class InsertCoinUseCase
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

    public function add(Coin $coin): void
    {
        $inserted = $this->repository->loadInserted();
        $inserted->add($coin);
        $this->repository->saveInserted($inserted);

    }
}