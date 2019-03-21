<?php

namespace App\Jobs;

use \App;
use App\Jobs\Job;
use App\Models\Slide;
use App\Models\SlideTypes\SliderContentInterface;

use DB;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateSlideJob extends Job implements SelfHandling
{
    private $name;
    private $slideType;
    private $sectionId;
    private $slidesCount;

    private $addEmptySlide     = [
        'video',
        'text',
        'heading',
        'intro',
        //'icon'
    ];
    private $addMultipleSlides = [
        'split' => 2,
    ];


    public function __construct($name, $slideType, $sectionId, $slidesCount)
    {
        $this->name        = $name;
        $this->slideType   = $slideType;
        $this->sectionId   = $sectionId;
        $this->slidesCount = $slidesCount;
    }

    /**
     * @param Slide $slide
     * @param \DB $
     * @return Slide
     */
    public function handle(Slide $slide)
    {
        $order             = \DB::table('slides')->max('ordering');
        $slide->name       = $this->name;
        $slide->type       = $this->slideType;
        $slide->ordering   = $this->slidesCount + 1;
        $slide->section_id = $this->sectionId;
        $slide->ordering   = $order + 1;
        $slide->save();

        if (in_array($this->slideType, $this->addEmptySlide)) {
            $this->addContentTo($slide);
        }

        if (array_key_exists($this->slideType, $this->addMultipleSlides)) {
            for ($i = 0; $i < $this->addMultipleSlides[$this->slideType]; $i++) {
                $this->addContentTo($slide);
            }
        }

        return $slide;
    }

    public function addContentTo(Slide $slide)
    {
        $sliderContent = App::make($this->slideType);
        $content       = $slide->createContent($sliderContent);
        $content->slides()->save($slide);
    }
}
