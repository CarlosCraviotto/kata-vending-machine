<?php
declare(strict_types=1);


namespace VendingMachine\Domain\Product;


final class ProductNotFound extends \InvalidArgumentException
{

    /**
     * ProductNotFound constructor.
     */
    public function __construct(string $productName)
    {
        parent::__construct(sprintf('We couldn\'t find the product %s', $productName));
    }
}