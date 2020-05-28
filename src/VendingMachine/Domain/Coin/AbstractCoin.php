<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

abstract class AbstractCoin implements Coin
{

    public function getValue(): float
    {
        return static::VALUE;
    }

    public function plus(Coin $coin): float
    {
        return $this->getValue() + $coin->getValue();
    }

    public function clone(): Coin
    {
        return clone $this;
    }

}