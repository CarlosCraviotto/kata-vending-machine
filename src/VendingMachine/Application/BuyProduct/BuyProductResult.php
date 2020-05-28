<?php
declare(strict_types=1);


namespace VendingMachine\Application\BuyProduct;


use VendingMachine\Domain\Coin\CoinCollection;
use VendingMachine\Domain\Product\Product;

final class BuyProductResult
{
    private $changeAsCoins;
    private $product;


    public function __construct(CoinCollection $changeAsCoins, Product $product)
    {
        $this->changeAsCoins = $changeAsCoins;
        $this->product = $product;
    }

    public function __toString(): string{
        $coinsAsString = '' .  $this->changeAsCoins;
        return strtoupper($this->product.'') . ((empty($coinsAsString))? '' : ', ' . $coinsAsString);
    }

}