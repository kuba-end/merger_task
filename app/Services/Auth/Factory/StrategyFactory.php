<?php

declare(strict_types=1);

namespace App\Services\Auth\Factory;

use App\Services\Auth\AuthStrategyInterface;
use App\Services\Auth\BarAuthStrategy;
use App\Services\Auth\BazAuthStrategy;
use App\Services\Auth\FooAuthStrategy;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;

class StrategyFactory implements StrategyFactoryInterface
{
    private AuthWS $authWS;
    private Authenticator $authenticator;
    private LoginService $loginService;

    public function __construct(AuthWS $authWS, Authenticator $authenticator, LoginService $loginService)
    {
        $this->authWS = $authWS;
        $this->authenticator = $authenticator;
        $this->loginService = $loginService;
    }

    public function create(string $login): ?AuthStrategyInterface
    {
        return match (true) {
            str_starts_with($login, 'FOO_') => new FooAuthStrategy($this->authWS),
            str_starts_with($login, 'BAR_') => new BarAuthStrategy($this->loginService),
            str_starts_with($login, 'BAZ_') => new BazAuthStrategy($this->authenticator),
            default => null,
        };
    }
}
