<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Product;

interface Product
{
    public function getPrice(): float;

    public function isSame(Product $product);

    public function getName(): string;
}