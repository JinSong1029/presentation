<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\SlideTypes\Image;
use Illuminate\Contracts\Bus\SelfHandling;

class DeleteLogoJob extends Job implements SelfHandling
{
    /**
     * @var
     */
    private $imageId;
    /**
     * @var
     */
    private $slide;

    /**
     * Create a new job instance.
     *
     * @param $slide
     * @param $imageId
     */
    public function __construct($slide, $imageId)
    {
        //
        $this->imageId = $imageId;
        $this->slide = $slide;
    }

    /**
     * Execute the job.
     *
     * @param Image $image
     */
    public function handle(Image $image)
    {
        $logo = $image->find($this->imageId);
        if ($logo->slides->count() > 1) {
            $this->slide->images()->detach($this->imageId);
        }
        else{
            $logo->delete();
        }
    }
}
