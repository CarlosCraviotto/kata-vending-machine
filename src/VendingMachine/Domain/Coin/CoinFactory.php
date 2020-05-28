<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

final class CoinFactory
{

    private static $coinsClasses = [
        'VendingMachine\Domain\Coin\Coin1',
        'VendingMachine\Domain\Coin\Coin025',
        'VendingMachine\Domain\Coin\Coin010',
        'VendingMachine\Domain\Coin\Coin005'
    ];

    static function buildFromArrayOfCoins (array $arrayOfRawCoins){
        return array_map(function ($coin) {
            return self::buildFromFloat($coin);
        }, $arrayOfRawCoins);
    }

    static function buildFromFloat(float $coinValue){
        foreach (self::$coinsClasses as $Class) {
            if (constant($Class . '::VALUE') === $coinValue) {
                return new $Class();
            }
        }

        throw new CoinNotFound($coinValue);
    }

}