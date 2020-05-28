<?php
declare(strict_types=1);


namespace VendingMachine\Domain\Coin;


final class CoinNotFound extends \InvalidArgumentException
{

    /**
     * CoinNotFound constructor.
     */
    public function __construct(float $coinValue)
    {
        parent::__construct(sprintf('We couldn\'t find a coin for the value %.2f', $coinValue));
    }
}