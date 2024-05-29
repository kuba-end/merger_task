<?php

namespace App\Services\Auth;

interface AuthStrategyInterface
{
    public function authenticate(array $credentials): bool;
}
