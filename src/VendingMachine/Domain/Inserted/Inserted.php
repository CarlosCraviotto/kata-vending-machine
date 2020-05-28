<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Inserted;

use VendingMachine\Domain\Coin\Coin;

final class Inserted
{
    private $coins;

    /**
     * Inserted constructor.
     * @param $coins
     */
    public function __construct($coins)
    {
        $this->coins = $coins;
    }

    public function add(Coin $coin): void
    {
        array_push($this->coins, $coin);
    }


    public function returnCoins()
    {
        $coins = $this->coins;
        $this->coins = [];
        return $coins;
    }

    public function getTotalMoneyInserted(): float
    {
        return array_reduce($this->coins, function ($total, Coin $coin) {
            return $total + $coin->getValue();
        }, 0.0);
    }

    public function toJson()
    {
        $values = (empty($this->coins)) ? [] : array_map(function (Coin $coin) {
            return $coin->getValue();
        }, $this->coins);

        return json_encode($values);
    }

}