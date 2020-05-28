<?php
declare(strict_types=1);

namespace VendingMachine\Application\InsertCoin;

//VendingMachine\Application\InsertCoin\InsertCoinCommand

final class InsertCoinCommand
{
    private $coin;


    public function __construct(float $coin)
    {
        $this->coin = $coin;
    }

    public function getCoin(): float
    {
        return $this->coin;
    }
}