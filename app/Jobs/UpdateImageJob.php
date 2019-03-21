<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateImageJob extends Job implements SelfHandling
{

    private $image;
    private $logo;
    private $slideImage;
    private $desc;
    /**
     * @var
     */
    private $use_presentation_color;

    /**
     * Create a new job instance.
     *
     * @param $slideImage
     * @param $image
     * @param $logo
     * @param $desc
     * @param $use_presentation_color
     */
    public function __construct($slideImage, $image, $logo, $desc, $use_presentation_color)
    {
        $this->image                  = $image;
        $this->logo                   = $logo;
        $this->slideImage             = $slideImage;
        $this->desc                   = $desc;
        $this->use_presentation_color = $use_presentation_color;
    }

    /**
     * Execute the job.
     *
     * @param ImageHandler $imageHandler
     */
    public function handle(ImageHandler $imageHandler)
    {
        $this->image             = $imageHandler->checkForUpdate($this->slideImage, $this->image, 'images');
        $this->slideImage->name  = $this->logo;
        $this->slideImage->image = $this->image;
        $this->slideImage->desc  = $this->desc;
        $this->slideImage->use_presentation_color  = $this->use_presentation_color;
        $this->slideImage->update();
    }
}
