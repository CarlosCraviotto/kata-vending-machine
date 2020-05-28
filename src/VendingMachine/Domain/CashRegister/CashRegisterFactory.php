<?php
declare(strict_types=1);


namespace VendingMachine\Domain\CashRegister;


use VendingMachine\Domain\CashRegister\CashRegister;
use VendingMachine\Domain\Coin\CoinFactory;

final class CashRegisterFactory
{
    public static function buildFromArray(array $coinsStocksRaw): CashRegister{

        $coinsStocksRaw = array_map(function (array $stock) {
            $coin = CoinFactory::buildFromFloat($stock[0]);
            return new CashStock($coin, $stock[1]);
        }, $coinsStocksRaw);

        return new CashRegister($coinsStocksRaw);
    }
}