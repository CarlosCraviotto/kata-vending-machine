<?php
declare(strict_types=1);

namespace VendingMachine\Shared\Domain\Helper;

final class FloatHelper
{
    public static function areEqual(float $float1, float $float2)
    {
        return (abs($float1 - $float2) < 0.0001);
    }
}