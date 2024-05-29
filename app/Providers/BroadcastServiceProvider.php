<?php

namespace App\Providers;

use App\Services\Movie\BarTitlesStrategy;
use App\Services\Movie\FooTitlesStrategy;
use App\Services\Movie\BazTitlesStrategy;
use App\Services\Movie\MovieFacade;
use App\Services\Movie\MovieFacadeInterface;
use App\Services\Movie\TitleFormatterService;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }

    public function register(): void
    {
        $this->app->bind(MovieFacadeInterface::class, MovieFacade::class);
        $this->app->bind('BazTitlesStrategy', BazTitlesStrategy::class);
        $this->app->bind('BarTitlesStrategy', BarTitlesStrategy::class);
        $this->app->bind('FooTitlesStrategy', FooTitlesStrategy::class);
        $this->app->bind(TitleFormatterService::class, function () {
            return new TitleFormatterService(...$this->app->tagged('title_strategy'));
        });

        $this->app->tag([
            'BazTitlesStrategy',
            'BarTitlesStrategy',
            'FooTitlesStrategy',
            ],
            'title_strategy');
    }
}
