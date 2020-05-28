<?php
declare(strict_types=1);

namespace VendingMachine\Domain\CashRegister;

use VendingMachine\Domain\CashRegister\CashStock;

use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\CoinCollection;
use VendingMachine\Domain\Inserted\Inserted;

use VendingMachine\Domain\CashRegister\CashStockFactory;
use VendingMachine\Shared\Domain\Helper\FloatHelper;

final class CashRegister
{

    private $cashStock;

    /**
     * CashRegister constructor.
     * @param $cashStock
     */
    public function __construct(array $cashStock)
    {
        $this->cashStock = $cashStock;
        $this->updateCashStocksOrderedDescByCoinValue();
    }

    public function getChange(Inserted $inserted, float $changeAsFloat)
    {
        $this->addInsertedCoinsToCashStock($inserted->returnCoins());
        return $this->prepareChange($changeAsFloat);
    }

    public function toJson()
    {
        $arrayOfCashStock = array_map(function (CashStock $cashStock) {
            return $cashStock->toArray();
        }, $this->cashStock);
        return json_encode($arrayOfCashStock);
    }

    private function addInsertedCoinsToCashStock(array $returnCoins)
    {
        foreach ($returnCoins as $coin) {
            $this->addCoinToStock($coin);
        }
    }

    private function addCoinToStock(Coin $coin): void
    {
        $coinStock = $this->getStockForCoin($coin);
        $coinStock = $coinStock->increaseNumberOfCoinsInOne($coin);
        $this->updateStockForCoin($coinStock);

    }

    private function getStockForCoin(Coin $coin): CashStock
    {
        $cashStockToReturn = null;
        foreach ($this->cashStock as $cashStock) {
            if ($cashStock->isSameCoin($coin)) {
                $cashStockToReturn = $cashStock;
                break;
            }
        }

        return ($cashStockToReturn) ? $cashStockToReturn : $this->createStockForCoin($coin);
    }


    private function updateStockForCoin(CashStock $newCashStock): void
    {
        foreach ($this->cashStock as $key => $cashStock) {
            if ($cashStock->isSameCoin($newCashStock->getCoin())) {
                $this->cashStock[$key] = $newCashStock;
                break;
            }
        }
    }

    private function createStockForCoin(Coin $coin): CashStock
    {
        $cashStock = CashStockFactory::buildCashStockFromCoin($coin);
        array_push($this->cashStock, $cashStock);
        return $cashStock;
    }

    private function prepareChange(float $changeAsFloat): CoinCollection
    {
        $coinsToReturn = new CoinCollection();
        $remain = $changeAsFloat;

        foreach ($this->cashStock as $key => $cashStock) {
            if ($cashStock->getCoinValue() > $remain) {
                continue;
            }

            $coinValue = $cashStock->getCoinValue();
            $coinStock = $cashStock->getValue();

            $numberOfCoins = $remain / $coinValue;

            $numberOfCoins = round($numberOfCoins, 2);
            $numberOfCoins = (int)floor($numberOfCoins);

            //get the number of coins or the maximum we can get
            $numberOfCoins = ($numberOfCoins <= $coinStock) ? $numberOfCoins : $coinStock;

            $priceCover = $coinValue * $numberOfCoins;

            $coinsToReturn->addBulk($cashStock->getCoin(), $numberOfCoins);

            //update the new remain
            $remain = $remain - $priceCover;

            //update the number of coins we have
            $this->cashStock[$key] = $cashStock->updateValue($cashStock->getValue() - $numberOfCoins);

            //if we got 0, stop in here.
            if (FloatHelper::areEqual($remain, 0)) {
                break;
            }
        }

        //if we didn't fill up the change with coins.
        if (!FloatHelper::areEqual($remain, 0)) {
//            print_r($changeAsFloat);
//            print_r("\n");
//            print_r($remain);
//            print_r("\n");
//            print_r($coinsToReturn->__toString());
            throw new NotChangeFound();
        }


        return $coinsToReturn;
    }

    private function updateCashStocksOrderedDescByCoinValue()
    {
        usort($this->cashStock, function (CashStock $a, CashStock $b) {
            if ($a->getCoinValue() === $b->getCoinValue()) {
                return 0;
            }
            return ($a->getCoinValue() < $b->getCoinValue()) ? 1 : -1;
        });
    }

}