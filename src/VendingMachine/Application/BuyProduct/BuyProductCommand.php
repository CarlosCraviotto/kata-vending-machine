<?php
declare(strict_types=1);

namespace VendingMachine\Application\BuyProduct;

//VendingMachine\Application\InsertCoin\InsertCoinCommand

final class BuyProductCommand
{
    private $product;


    public function __construct(string $product)
    {
        $this->product = $product;
    }

    public function getProduct(): string
    {
        return $this->product;
    }
}