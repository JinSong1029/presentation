<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class FolderModeProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $oneFolderEnabled    = env('ONE_FOLDER_MODE', null);
        $appWorksInOneFolder = !is_null($oneFolderEnabled) && $oneFolderEnabled == 'true';

        $mode = $appWorksInOneFolder ? $this->detectModeByDomain() : getenv('APP_MODE');

        \Config::set('app_mode', $mode);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function detectModeByDomain()
    {
        return Str::contains(request()->url(), 'dashboard') ? 'dashboard' : 'public';
    }
}
