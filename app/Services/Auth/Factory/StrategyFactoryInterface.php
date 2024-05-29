<?php

namespace App\Services\Auth\Factory;

use App\Services\Auth\AuthStrategyInterface;

interface StrategyFactoryInterface
{
    public function create(string $login): ?AuthStrategyInterface;
}
