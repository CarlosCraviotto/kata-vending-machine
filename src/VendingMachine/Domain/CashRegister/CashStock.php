<?php
declare(strict_types=1);


namespace VendingMachine\Domain\CashRegister;


use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Shared\Domain\Helper\FloatHelper;

final class CashStock
{
    private $value;
    private $coin;

    /**
     * Stock constructor.
     * @param $value
     */
    public function __construct(Coin $coin, int $value)
    {
        $this->coin = $coin;
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isSameCoin(Coin $coin): bool
    {
        return FloatHelper::areEqual($this->coin->getValue(), $coin->getValue());
    }

    public function getCoinValue(): float
    {
        return $this->coin->getValue();
    }

    public function getCoin(): Coin
    {
        return $this->coin->clone();
    }

    public function updateValue(int $newValue): CashStock
    {
        return new CashStock($this->coin->clone(), $newValue);
    }

    public function increaseNumberOfCoinsInOne(): CashStock
    {
        return $this->updateValue($this->getValue() + 1);
    }

    public function toArray()
    {
        return [$this->getCoinValue(), $this->getValue()];
    }

}