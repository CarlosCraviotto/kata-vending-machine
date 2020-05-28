<?php
declare(strict_types=1);


namespace VendingMachine\Domain\CashRegister;


final class NotEnoughStockForChange extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Not enough stock for change');
    }
}