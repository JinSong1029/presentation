<?php

use Illuminate\Support\Str;

function asset($path, $secure = null)
{
    if (getenv('APP_MODE') != 'dashboard') {
        if (Str::contains($path, 'img')) {
            return env('ASSET_HOST', 'https://dashboard.walkermorris.co.uk') . '/' . trim($path);
        }
    }

    return app('url')->asset($path, $secure);
}

function background_color($presentation, $slideable)
{

    $color = '';

    if ($slideable->use_presetnation_color && !empty($presentation->color))
        $color = $presentation->color;

    return $color;
}