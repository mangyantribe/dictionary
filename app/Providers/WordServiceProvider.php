<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\WordInterface;
use App\Repositories\WordRepository;
class WordServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WordInterface::class,WordRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
