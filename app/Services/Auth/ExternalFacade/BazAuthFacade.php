<?php

declare(strict_types=1);

namespace App\Services\Auth\ExternalFacade;

use Illuminate\Support\Facades\Facade;

class BazAuthFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'baz.auth';
    }
}
