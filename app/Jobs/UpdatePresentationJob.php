<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\Presentation\PresentationRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdatePresentationJob extends Job implements SelfHandling
{


    public  $presentation;
    public  $client;
    public  $title;
    public  $image;
    public  $detachedLogoId;
    public  $new_image;
    public  $new;
    public $color;

    /**
     * UpdatePresentationJob constructor.
     * @param $presentation
     * @param $client
     * @param $title
     * @param $image
     * @param $detachedLogoId
     * @param $new
     * @param $color
     */
    public function __construct($presentation, $client, $title, $image, $detachedLogoId, $new, $color)
    {
        //
        $this->presentation   = $presentation;
        $this->client         = $client;
        $this->title          = $title;
        $this->image          = $image;
        $this->detachedLogoId = $detachedLogoId;
        $this->new            = $new;
        $this->color          = $color;
    }


    public function handle(PresentationRepository $presentations, ImageHandler $imageHandler)
    {
        \Log::info('new ' . $this->new);
        \Log::info('detached  ' . $this->detachedLogoId);
        $this->image = $imageHandler->checkForUpdate($this->presentation, $this->image, 'presentations');


        if ($this->detachedLogoId) {
            $imageHandler->deleteImage($this->presentation->image, 'presentations');
            $this->image = '';
        }

        $presentation = $presentations->updatePresentation($this->presentation, $this);

        return $presentation;
    }
}
