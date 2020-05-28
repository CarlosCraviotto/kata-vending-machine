<?php
declare(strict_types=1);


namespace VendingMachine\Domain\ProductsStocks;


final class NotEnoughMoneyInsertedToBuyProduct extends \InvalidArgumentException
{
    public function __construct($totalMoneyInserted)
    {
        parent::__construct(sprintf('Not enough money inserted (%.2f) to buy product', $totalMoneyInserted));
    }
}