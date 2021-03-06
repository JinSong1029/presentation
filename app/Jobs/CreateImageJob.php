<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\SlideTypes\Image;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateImageJob extends Job implements SelfHandling
{
    private $slide_id;
    private $image;
    private $logo;
    private $desc;

    /**
     * Create a new job instance.
     *
     * @param $slide_id
     * @param $image
     * @param $logo
     * @param $desc
     */
    public function __construct($slide_id, $image, $logo,$desc)
    {
        $this->slide_id = $slide_id;
        $this->image = $image;
        $this->logo = $logo;
        $this->desc = $desc;
    }

    /**
     * Execute the job.
     *
     * @param ImageHandler $imageHandler
     * @param Image $newImage
     * @return Image
     */
    public function handle(ImageHandler $imageHandler, Image $newImage)
    {
        $image = $imageHandler->uploadImage($this->image, 'images');
        $newImage->name = $this->logo;
        $newImage->image = $image;
        $newImage->desc = $this->desc;

        $newImage->save();
        $newImage->slides()->attach($this->slide_id);

        return $newImage;
    }
}
