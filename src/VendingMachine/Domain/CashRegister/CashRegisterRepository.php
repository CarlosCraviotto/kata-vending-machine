<?php
declare(strict_types=1);


namespace VendingMachine\Domain\CashRegister;


interface CashRegisterRepository
{
    public function loadCashRegister(): CashRegister;

    public function saveCashRegister(CashRegister $inserted): void;
}