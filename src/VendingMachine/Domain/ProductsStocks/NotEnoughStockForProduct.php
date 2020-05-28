<?php
declare(strict_types=1);


namespace VendingMachine\Domain\ProductsStocks;


final class NotEnoughStockForProduct extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Not enough stock for product');
    }
}