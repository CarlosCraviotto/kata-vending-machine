<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Product;

abstract class AbstractProduct implements Product
{
    public function getPrice(): float
    {
        return static::PRICE;
    }

    public function isSame(Product $product): bool
    {
        return (static::NAME === $product->getName());
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return static::NAME;
    }
}