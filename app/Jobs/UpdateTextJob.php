<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
// use App\Models\Presentation\PresentationRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateTextJob extends Job implements SelfHandling
{

    private $image;
    // public  $presentation;
    public  $background;

    /**
     * UpdatePresentationJob constructor.
     *
     * @param $presentation
     * @param $background
     * @param $image
    */

    public function __construct($image)
    {
        $this->image = $image;
    }

    public function handle(ImageHandler $imageHandler)
    {

        $image = $imageHandler->uploadImage($this->image,'texts');

        // $this->texts->text = $this->text;

        // $this->texts->update();

        return $image;
    }
}
