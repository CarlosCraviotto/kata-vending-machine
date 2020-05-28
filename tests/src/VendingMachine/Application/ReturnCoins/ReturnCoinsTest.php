<?php


namespace VendingMachine\Test\Application\InsertCoin;

use PHPUnit\Framework\TestCase;

use VendingMachine\Application\ReturnCoins\ReturnCoinsHandler;
use VendingMachine\Application\ReturnCoins\ReturnCoinsQuery;

use VendingMachine\Test\Infrastructure\Repository\InMemoryInsertedRepository;

class ReturnCoinsTest extends TestCase
{

    /** @test */
    public function it_should_return_the_coins()
    {

        $repository = new InMemoryInsertedRepository('[0.25,0.10]');
        $command = new ReturnCoinsQuery();
        $handler = new ReturnCoinsHandler($repository);

        $result = $handler($command);

        $inserted = $repository->loadInserted();

        $this->assertEquals('0.25, 0.1', $result->__toString());
        $this->assertEquals('[]', $inserted->toJson());
    }

}
