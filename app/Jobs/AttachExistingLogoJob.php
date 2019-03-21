<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class AttachExistingLogoJob extends Job implements SelfHandling
{
    /**
     * @var
     */
    private $slide;
    /**
     * @var
     */
    private $imageId;
    /**
     * @var
     */
    private $position;
    /**
     * @var
     */
    private $detachImage;

    /**
     * Create a new job instance.
     *
     * @param $slide
     * @param $imageId
     * @param $position
     * @param $detachImage
     */
    public function __construct($slide, $imageId, $position, $detachImage)
    {
        //
        $this->slide       = $slide;
        $this->imageId     = $imageId;
        $this->position    = $position;
        $this->detachImage = $detachImage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->slide->images()->attach($this->imageId);
        $this->slide->images()->updateExistingPivot($this->imageId, ['position' => $this->position]);
        if ($this->detachImage) {
            $this->slide->images()->detach($this->detachImage);
        }
    }
}
