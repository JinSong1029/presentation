<?php

namespace App\Http\ViewComposers;


use App\Models\SlideTypes\SlideType;
use Illuminate\Contracts\View\View;

class PresentationComposer
{

    private $slideType;

    public function __construct(SlideType $slideType)
    {

        $this->slideType = $slideType;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     */
    public function compose(View $view)
    {

        $view->with('typesSelect', $this->slideType->toSelect());
    }
}