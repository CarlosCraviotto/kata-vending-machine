<?php
declare(strict_types=1);


namespace VendingMachine\Domain\ProductsStocks;


use VendingMachine\Domain\Product\Product;
use VendingMachine\Shared\Domain\Helper\FloatHelper;

final class ProductStock
{
    private $stock;
    private $product;

    /**
     * ProductStock constructor.
     * @param $stock
     * @param $product
     */
    public function __construct(Product $product, Stock $stock)
    {
        $this->product = $product;
        $this->stock = $stock;
    }

    public function getProduct(): Product{
        return $this->product;
    }

    public function isSameProduct(Product $product)
    {
        return $this->product->isSame($product);
    }

    public function buyProduct(float $totalMoneyInserted)
    {
        if (!$this->isEnoughMoneyToBuyProduct($totalMoneyInserted)) {
            throw new NotEnoughMoneyInsertedToBuyProduct($totalMoneyInserted);
        }

        $this->updateStockForBuyedProduct();

        return $this->getChangeAsFloat($totalMoneyInserted);
    }


    public function toArray()
    {
        return [$this->product->getName(), $this->stock->getValue()];
    }

    private function updateStockForBuyedProduct()
    {
        $this->stock = $this->stock->reduceOne();
    }

    private function isEnoughMoneyToBuyProduct(float $totalMoneyInserted): bool
    {
        $changeAsFloat = $this->getChangeAsFloat($totalMoneyInserted);
        return ($changeAsFloat > 0 || FloatHelper::areEqual($changeAsFloat, 0));
    }

    private function getChangeAsFloat(float $totalMoneyInserted): float
    {
        $result = $totalMoneyInserted - $this->product->getPrice();

        return $result;
    }


}