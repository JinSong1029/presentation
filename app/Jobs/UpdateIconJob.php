<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateIconJob extends Job implements SelfHandling
{

    private $image;
    private $logo;
    private $slideImage;
    /**
     * @var
     */
    private $desc;

    /**
     * Create a new job instance.
     *
     * @param $slideImage
     * @param $image
     * @param $logo
     * @param $desc
     */
    public function __construct($slideImage,$image, $logo,$desc)
    {
        $this->image = $image;
        $this->logo = $logo;
        $this->slideImage = $slideImage;
        $this->desc = $desc;
    }

    /**
     * Execute the job.
     *
     * @param ImageHandler $imageHandler
     */
    public function handle(ImageHandler $imageHandler)
    {
        $this->image = $imageHandler->checkForUpdate($this->slideImage, $this->image, 'icons');
        $this->slideImage->name = $this->logo;
        $this->slideImage->image = $this->image;
        $this->slideImage->desc = $this->desc;
        $this->slideImage->update();
    }
}
