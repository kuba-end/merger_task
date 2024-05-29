<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthFacade;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    private AuthFacade $authFacade;
    public function __construct(AuthFacade $authFacade)
    {
        $this->authFacade = $authFacade;
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['status' => 'failure', 'message' => 'Invalid input format'], 400);
        }
        if (!isset($credentials['login']) || !isset($credentials['password'])) {
            return response()->json(['status' => 'failure', 'message' => 'Login or password not set'], 400);
        }
        $loginStatus = $this->authFacade->login($credentials);

        if (null === $loginStatus) {
            return response()->json([
                'status' => 'failure',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'token' =>  $loginStatus,
        ]);
    }
}
