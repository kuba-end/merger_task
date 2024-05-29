<?php

declare(strict_types=1);

namespace App\Services\Auth;

use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;

class FooAuthStrategy implements AuthStrategyInterface
{
    private AuthWS $authWS;

    public function __construct(AuthWS $authWS)
    {
        $this->authWS = $authWS;
    }

    public function authenticate(array $credentials): bool
    {
        try {
            $this->authWS->authenticate($credentials['login'], $credentials['password']);
        } catch (AuthenticationFailedException $exception) {
            // TODO $this->logger->error($exception->getMessage(), $exception->getTrace());

            return false;
        }

        return true;
    }
}
