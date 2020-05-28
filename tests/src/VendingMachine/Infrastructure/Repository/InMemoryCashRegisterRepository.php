<?php
declare(strict_types=1);

namespace VendingMachine\Test\Infrastructure\Repository;

use VendingMachine\Domain\CashRegister\CashRegister;
use VendingMachine\Domain\CashRegister\CashRegisterRepository;
use VendingMachine\Domain\CashRegister\CashRegisterFactory;

final class InMemoryCashRegisterRepository extends InMemoryRepository implements CashRegisterRepository
{

    protected $defaultData = '[
                              [0.05, 100],
                              [0.10, 50],
                              [0.25, 20],
                              [1.0, 5]
                            ]';

    public function __construct(string $initialData = null)
    {
        parent::__construct($initialData);
    }

    public function loadCashRegister(): CashRegister
    {
        $fileContent = $this->loadData();
        return CashRegisterFactory::buildFromArray($fileContent);
    }

    public function saveCashRegister(CashRegister $cashRegister): void
    {
        $cashRegisterJson = $cashRegister->toJson();
        $this->saveContentToFile($cashRegisterJson);
    }
}