<?php

declare(strict_types=1);

namespace App\Services\Auth\JWT;

use Tymon\JWTAuth\Facades\JWTAuth;

class JWTService
{
    public static function generate(array $credentials): ?string
    {
        $customClaims = [
            'login' => $credentials['login'],
            'context' => substr($credentials['login'], 0, 3),
        ];

        if (!$token = JWTAuth::claims(
            $customClaims
           )->attempt(['name' => $credentials['login'], 'password' => $credentials['password']])) {
            return null;
        }

        return $token;
    }
}
