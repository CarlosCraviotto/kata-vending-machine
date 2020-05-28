<?php
declare(strict_types=1);


namespace VendingMachine\Domain\Coin;


final class CoinCollection
{

    private $coins;

    /**
     * CoinCollection constructor.
     * @param $coins
     */
    public function __construct()
    {
        $this->coins = [];
    }

    public function add(Coin $coin)
    {
        array_push($this->coins, $coin);
    }

    public function addBulk(Coin $coin, int $howManyCoins)
    {
        for ($i = 0; $i < $howManyCoins; $i++) {
            $this->add($coin->clone());
        }
    }

    public function __toString()
    {
        $resultString = '';
        array_map(function (Coin $coin) use(&$resultString) {
            $resultString .= $coin->getValue() . ', ';
        }, $this->coins);

        if (!empty($resultString)) {
            $resultString = substr($resultString, 0, strlen($resultString)-2);
            $resultString = ($resultString)? $resultString : '';
        }

        return $resultString;
    }

}