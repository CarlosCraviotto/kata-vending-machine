<?php
declare(strict_types=1);


namespace VendingMachine\Domain\Inserted;


interface InsertedRepository
{
    public function loadInserted(): Inserted;
    public function saveInserted(Inserted $inserted): void;
}