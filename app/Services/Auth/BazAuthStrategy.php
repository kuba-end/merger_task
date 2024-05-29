<?php

declare(strict_types=1);

namespace App\Services\Auth;

use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;

class BazAuthStrategy implements AuthStrategyInterface
{
    private Authenticator $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function authenticate(array $credentials): bool
    {
        if ($this->authenticator->auth($credentials['login'], $credentials['password']) instanceof Success) {
            return true;
        }

        return false;
    }
}
