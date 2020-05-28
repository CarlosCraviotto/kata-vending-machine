<?php


namespace VendingMachine\Domain\Coin;


interface Coin
{
    public function getValue(): float;
    public function plus(Coin $coin): float;
    public function clone(): Coin;
}