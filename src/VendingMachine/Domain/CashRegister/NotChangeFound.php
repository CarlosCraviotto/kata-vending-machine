<?php
declare(strict_types=1);


namespace VendingMachine\Domain\CashRegister;


final class NotChangeFound extends \InvalidArgumentException
{

    /**
     * NotChangeFound constructor.
     */
    public function __construct()
    {
        parent::__construct('Not change found');
    }
}