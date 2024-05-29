<?php

declare(strict_types=1);

namespace App\Services\Auth\ExternalFacade;

use Illuminate\Support\Facades\Facade;

class BarAuthFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bar.auth';
    }
}
