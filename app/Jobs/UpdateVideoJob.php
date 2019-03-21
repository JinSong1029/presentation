<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateVideoJob extends Job implements SelfHandling
{

    private $video;
    private $url;
    private $image;
    private $title;

    /**
     * Create a new job instance.
     *
     * @param $video
     * @param $url
     * @param $image
     * @param $title
     */
    public function __construct($video, $url, $image, $title)
    {
        //

        $this->video = $video;
        $this->url = $url;
        $this->image = $image;
        $this->title = $title;
    }

    /**
     * Execute the job.
     *
     * @param ImageHandler $imageHandler
     */
    public function handle(ImageHandler $imageHandler)
    {
        $this->image = $imageHandler->checkForUpdate($this->video, $this->image, 'videos');
        $this->video->title = $this->title;
        $this->video->url = $this->url;
        $this->video->image = $this->image;
        $this->video->update();
    }
}
