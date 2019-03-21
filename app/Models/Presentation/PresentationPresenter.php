<?php

namespace App\Models\Presentation;


use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class PresentationPresenter extends Presenter
{

    protected $background = null;

    public function created()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->entity->created_at)->format('d M y');
    }
    public function updated()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->entity->updated_at)->format('d M y');
    }

    public function createdShort()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->entity->updated_at)->format('F y');
    }

    public function secondarySections()
    {
        $sections = $this->entity->sections->filter(function($section){
            return $section->name != DefaultSections::introPageName();
        });

        return $sections;

    }

    public function introSection()
    {
        $sections = $this->entity->sections->filter(function($section){
            return $section->name == DefaultSections::introPageName();
        });

        return $sections->first();
    }


    public function introSlideText()
    {
        $section = $this->entity->sections->where('name',DefaultSections::introPageName())->first();
            if($section){
                $slide = $section->slides->first();
                   if($slide){
                       return $slide->texts[0]->text;
                   }
                return '';
            }


        return '';
    }

    public function backgroundFor($slideable)
    {

        if(!$slideable){
            return null;
        }


        $this->background = '';

        if ($slideable->use_presentation_color && !empty($this->entity->color)){

            $this->background = $this->entity->color;
        }


        return $this->background;
    }
}
