<?php
declare(strict_types=1);

namespace VendingMachine\Application\ReturnCoins;

use VendingMachine\Domain\Coin\Coin;

final class ReturnCoinsResult
{
    private $coins;

    /**
     * ReturnCoinsResult constructor.
     * @param $coins
     */
    public function __construct($coins)
    {
        $this->coins = array_map(function (Coin $coin) {
            return $coin->getValue();
        }, $coins);
    }

    public function __toString()
    {
        $result = '';
        foreach ($this->coins as $coin) {
            $result .= "$coin, ";
        }

        if (count($this->coins) > 0) {
            $result = substr($result, 0, -2);
            $result = ($result === false) ? '' : $result;
        }

        return $result;
    }

    public function isEmpty()
    {
        return (count($this->coins) === 0);
    }


}