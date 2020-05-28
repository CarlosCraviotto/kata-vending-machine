<?php
declare(strict_types=1);


namespace VendingMachine\Domain\ProductsStocks;


final class Stock
{
    private $value;

    /**
     * Stock constructor.
     * @param $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function reduceOne(): Stock
    {
        if ($this->value < 1) {
            throw new NotEnoughStockForProduct();
        }
        return new Stock($this->value-1);
    }

    public function getValue(): int
    {
        return $this->value;
    }

}