<?php
declare(strict_types=1);

namespace VendingMachine\Infrastructure\Repository;

use VendingMachine\Domain\Coin\CoinFactory;
use VendingMachine\Domain\Inserted\Inserted;
use VendingMachine\Domain\Inserted\InsertedRepository;

final class JsonFileInsertedRepository extends JsonFileRepository implements InsertedRepository
{
    protected $file = 'inserted.json';
    protected $defaultFile = 'default_inserted.json';

    public function loadInserted(): Inserted
    {
        $fileContent = $this->loadFileContent();
        $arrayOfCoins = CoinFactory::buildFromArrayOfCoins($fileContent);
        return new Inserted($arrayOfCoins);
    }

    public function saveInserted(Inserted $inserted): void
    {
        $insertedJson = $inserted->toJson();
        $this->saveContentToFile($insertedJson);
    }

}