<?php


namespace App\Providers;


use App\Models\SlideTypes\Image;
use App\Models\SlideTypes\Procedure;
use App\Models\SlideTypes\PyramidGroup;
use App\Models\SlideTypes\Quote;
use App\Models\SlideTypes\SplitScreen;
use App\Models\SlideTypes\Text;
use App\Models\SlideTypes\Tombstone;
use App\Models\SlideTypes\Video;
use Illuminate\Support\ServiceProvider;

class BindingsServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        \App::bind('picture', function ($app) {
            return new Image();
        });
        \App::bind('welcome', function ($app) {
            return new Image();
        });
        \App::bind('tombstone', function ($app) {
            return new Tombstone();
        });
        \App::bind('logo', function ($app) {
            return new Image();
        });
        \App::bind('text', function ($app) {
            return new Text();
        });
        \App::bind('heading', function ($app) {
            return new Text();
        });
        \App::bind('intro', function ($app) {
            return new SplitScreen();
        });
        \App::bind('video', function ($app) {
            return new Video();
        });
        \App::bind('procedure', function ($app) {
            return new Procedure();
        });
        \App::bind('quote', function ($app) {
            return new Quote();
        });
        \App::bind('pyramid', function ($app) {
            return new PyramidGroup();
        });
        \App::bind('split', function ($app) {
            return new SplitScreen();
        });

    }
}