<?php
declare(strict_types=1);

namespace VendingMachine\Infrastructure\Repository;


abstract class JsonFileRepository
{

    protected $pathFiles = __DIR__ . '/../../../../etc/infrastructure/data/';


    protected function loadFileContent () {
        if (!$this->checkIfFileExist()) {
            $this->createStartFile();
        }

      $strJsonFileContents = file_get_contents($this->getFileName());
      return json_decode($strJsonFileContents, true);
    }

    protected function checkIfFileExist(){
        return file_exists($this->getFileName());
    }

    protected function createStartFile(){
        copy($this->getDefaultFileName(), $this->getFileName());
    }

    protected function getFileName(): string {
        return $this->pathFiles . $this->file;
    }

    protected function getDefaultFileName(): string{
        return $this->pathFiles . $this->defaultFile;
    }

    protected function saveContentToFile(string $insertedJson)
    {
        file_put_contents($this->getFileName(), $insertedJson);
    }
}