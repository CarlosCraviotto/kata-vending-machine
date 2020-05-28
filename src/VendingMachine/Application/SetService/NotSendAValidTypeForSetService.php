<?php
declare(strict_types=1);

namespace VendingMachine\Application\SetService;

final class NotSendAValidTypeForSetService extends \InvalidArgumentException
{

    /**
     * NotSendAValidTypeForSetService constructor.
     */
    public function __construct(string $type)
    {
        parent::__construct(sprintf('This (%s) is not a valid type', $type));
    }
}