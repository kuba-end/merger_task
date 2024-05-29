<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Services\Auth\Factory\StrategyFactory;
use App\Services\Auth\Factory\StrategyFactoryInterface;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

    public function register(): void
    {
        $this->app->bind(StrategyFactoryInterface::class, StrategyFactory::class);
        $this->app->bind('foo.auth', function ($app) {
            return new AuthWS();
        });
        $this->app->bind('bar.auth', function ($app) {
            return new LoginService();
        });
        $this->app->bind('baz.auth', function ($app) {
            return new Authenticator();
        });
    }
}
