<?php

namespace App\Providers;

use App\Models\Presentation;
use App\Models\Section;
use App\Models\Slide;
use App\Models\SlideTypes\Gallary;
use App\Models\SlideTypes\Image;
use App\Models\SlideTypes\Procedure;
use App\Models\SlideTypes\PyramidGroup;
use App\Models\SlideTypes\Quote;
use App\Models\SlideTypes\SplitScreen;
use App\Models\SlideTypes\Text;
use App\Models\SlideTypes\Tombstone;
use App\Models\SlideTypes\Video;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace       = 'App\Http\Controllers';
    protected $sluggableRoutes = [
        'presentations' => Presentation::class,

    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        //
        parent::boot($router);

        $router->model('users', 'App\Models\User');
        $router->model('defaults', 'App\Models\Presentation\DefaultSections');

        $router->model('sections', Section::class);
        $router->model('slides', Slide::class);


        foreach ($this->sluggableRoutes as $route => $model) {
            $router->bind($route, function ($id) use ($model, $router) {
//                $adminRoute = str_contains($router->current()->uri(), 'admin');
//                if ( !$adminRoute)
//                    return $model::where('key', '=', $id)->first();
                if (is_numeric($id)) {
                    return $model::findOrFail(intval($id));
                } else {
                    return $model::where('slug', '=', $id)->first();
                }
            });
        }
        $router->model('videos', Video::class);
        $router->model('tombstones', Tombstone::class);
        $router->model('texts', Text::class);
        $router->model('pictures', Image::class);
        $router->model('quotes', Quote::class);
        $router->model('procedures', Procedure::class);
        $router->model('pyramidGroups', PyramidGroup::class);
        $router->model('splits', SplitScreen::class);
        $router->model('gallarys', Gallary::class);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
