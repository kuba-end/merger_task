<?php

declare(strict_types=1);

namespace App\Services\Auth;

use External\Bar\Auth\LoginService;

class BarAuthStrategy implements AuthStrategyInterface
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function authenticate(array $credentials): bool
    {
        return $this->loginService->login($credentials['login'], $credentials['password']);
    }
}
