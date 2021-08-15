<?php

namespace App\Providers;

use App\Http\Services\Board;
use App\Http\Services\Game;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        $this->app->singleton('New Game', function() {
            return new Game((new Board())->convertToString());
        });
    }
}
