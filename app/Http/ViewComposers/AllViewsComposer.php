<?php
namespace App\Http\ViewComposers;

use App\Models\Lang\Language;
use App\Models\Page\PageTitlesHandler;
use App\Models\SlideTypes\SlideType;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class AllViewsComposer
{
    private $auth;
    private $request;
    private $titlesHandler;
    private $slideType;

    public function __construct(Guard $auth, Request $request, PageTitlesHandler $titlesHandler, SlideType $slideType)
    {
        $this->auth = $auth;
        $this->request = $request;
        $this->titlesHandler = $titlesHandler;
        $this->slideType = $slideType;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     */
    public function compose(View $view)
    {
        $title = $this->request->route() ? $this->request->route()->getUri() : 'notFound';
        $view->with('currentUser', $this->auth->user());
        $view->with('title', $this->titlesHandler->getTitle($title));
        $allSlides =  $this->slideType->toSelect();
//        $intro = array_only($allSlides,['intro']);
//        array_forget($allSlides,'intro');
//        dd($intro);
//        $view->with('introSelect',$intro);
        $view->with('typesSelect',$allSlides);
    }
}