<?php

namespace Hasan\Tagme;

use Illuminate\Support\ServiceProvider;

class TaggyServiceProvider extends ServiceProvider
{
    /**
     * Current Working Direct
     */
    CONST CWD = __DIR__;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(self::CWD . "/../migrations");
    }
}
