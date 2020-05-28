<?php
declare(strict_types=1);


namespace VendingMachine\Domain\ProductsStocks;


final class StockForProductNotFound extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Stock for product not found');
    }
}