<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Services\Auth\Factory\StrategyFactoryInterface;
use App\Services\Auth\JWT\JWTService;

class AuthFacade
{
    private StrategyFactoryInterface $strategyFactory;

    public function __construct(StrategyFactoryInterface $strategyFactory)
    {
        $this->strategyFactory = $strategyFactory;
    }

    public function login(array $credentials): ?string
    {
        $strategy = $this->strategyFactory->create($credentials['login']);

        if (null !== $strategy && $strategy->authenticate($credentials)) {
           return  $this->generateToken($credentials);
        }

        return null;
    }

    private function generateToken(array $credentials): ?string
    {
        return JWTService::generate($credentials);
    }
}
