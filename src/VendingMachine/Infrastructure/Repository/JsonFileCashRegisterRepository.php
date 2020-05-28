<?php
declare(strict_types=1);

namespace VendingMachine\Infrastructure\Repository;


use VendingMachine\Domain\CashRegister\CashRegisterRepository;

use VendingMachine\Domain\CashRegister\CashRegister;
use VendingMachine\Domain\CashRegister\CashRegisterFactory;

final class JsonFileCashRegisterRepository extends JsonFileRepository implements CashRegisterRepository
{
    protected $file = 'cash_register.json';
    protected $defaultFile = 'default_cash_register.json';

    public function loadCashRegister(): CashRegister
    {
        $fileContent = $this->loadFileContent();
        return CashRegisterFactory::buildFromArray($fileContent);
    }

    public function saveCashRegister(CashRegister $cashRegister): void
    {
        $cashRegisterJson = $cashRegister->toJson();
        $this->saveContentToFile($cashRegisterJson);
    }

}