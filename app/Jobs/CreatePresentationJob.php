<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\Presentation\DefaultSections;
use App\Models\Presentation\PresentationRepository;
use App\Models\Section;
use App\Models\Section\SectionsRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\Collection;


class CreatePresentationJob extends Job implements SelfHandling
{
    private $title;
    private $client;
    private $image;
    /**
     * @var
     */
    private $color;


    /**
     * @param $title
     * @param $client
     * @param $image
     * @param $color
     */
    public function __construct($title, $client, $image, $color)
    {
        $this->title  = $title;
        $this->client = $client;
        $this->image  = $image;
        $this->color = $color;
    }


    public function handle(PresentationRepository $presentations, SectionsRepository $sectionsRepo, ImageHandler $imageHandler)
    {
        $sections = $sectionsRepo->copyDefaults();
        $image    = null;

        if ($this->image)
            $image = $imageHandler->uploadImage($this->image, 'presentations');


        $presentation = $presentations->createPresentation($this->title, $this->client, $image, $this->color);
        $presentation->sections()->saveMany($sections);

        auth()->user()->presentations()->save($presentation);

        return $presentation;
    }
}
