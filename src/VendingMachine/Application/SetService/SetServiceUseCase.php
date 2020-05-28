<?php
declare(strict_types=1);

namespace VendingMachine\Application\SetService;

use VendingMachine\Domain\CashRegister\CashRegisterFactory;
use VendingMachine\Domain\ProductsStocks\ProductsStocksFactory;
use VendingMachine\Domain\ProductsStocks\ProductsStocksRepository;
use VendingMachine\Domain\CashRegister\CashRegisterRepository;

final class SetServiceUseCase
{

    private $productsStocksRepository;
    private $cashRegisterRepository;

    /**
     * InsertCoinHandler constructor.
     * @param $repository
     */
    public function __construct(
        ProductsStocksRepository $productsStocksRepository,
        CashRegisterRepository $cashRegisterRepository
    )
    {
        $this->productsStocksRepository = $productsStocksRepository;
        $this->cashRegisterRepository = $cashRegisterRepository;
    }

    public function setService(string $type, string $data)
    {

        $data = json_decode($data, true);

        switch ($type) {
            case 'products':
                $this->saveDataForProducts($data);
                break;
            case 'change':
                $this->saveDataForChange($data);
                break;
            default:
                throw new NotSendAValidTypeForSetService($type);
                break;
        }
    }

    private function saveDataForProducts(array $data)
    {
        $productsStocks = ProductsStocksFactory::buildFromArray($data);
        $this->productsStocksRepository->saveProductsStocks($productsStocks);
    }

    private function saveDataForChange(array $data)
    {
        $cashRegister = CashRegisterFactory::buildFromArray($data);
        $this->cashRegisterRepository->saveCashRegister($cashRegister);
    }
}