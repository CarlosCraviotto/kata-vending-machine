<?php
declare(strict_types=1);

namespace VendingMachine\Test\Infrastructure\Repository;

use VendingMachine\Domain\Coin\CoinFactory;
use VendingMachine\Domain\Inserted\Inserted;
use VendingMachine\Domain\Inserted\InsertedRepository;

final class InMemoryInsertedRepository extends InMemoryRepository implements InsertedRepository
{

    protected $defaultData = '[]';

    public function __construct(string $initialData = null)
    {
        parent::__construct($initialData);
    }


    public function loadInserted(): Inserted
    {
        $fileContent = $this->loadData();
        $arrayOfCoins = CoinFactory::buildFromArrayOfCoins($fileContent);
        return new Inserted($arrayOfCoins);
    }

    public function saveInserted(Inserted $inserted): void
    {
        $insertedJson = $inserted->toJson();
        $this->saveContentToFile($insertedJson);
    }
}