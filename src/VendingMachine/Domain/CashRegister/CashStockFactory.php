<?php
declare(strict_types=1);


namespace VendingMachine\Domain\CashRegister;


use VendingMachine\Domain\Coin\Coin;

final class CashStockFactory
{
    public static function buildCashStockFromCoin(Coin $coin, int $stockInt = 0){
        return new CashStock($coin, $stockInt);
    }
}