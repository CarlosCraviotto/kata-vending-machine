<?php
declare(strict_types=1);

namespace VendingMachine\Test\Infrastructure\Repository;


abstract class InMemoryRepository
{
    private $data;
    /**
     * JsonFileInsertedRepository constructor.
     * @param $data
     */
    public function __construct($initialData = null)
    {
        $this->data = ($initialData)? $initialData : $this->defaultData;
    }

    protected function loadData () {
      return json_decode($this->data, true);
    }

    protected function getFileName(): string {
        return $this->pathFiles . $this->file;
    }

    protected function saveContentToFile(string $insertedJson)
    {
        $this->data = $insertedJson;
    }
}