<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Repositories\SplitsRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class AddSplitJob extends Job implements SelfHandling
{
    public $text;
    public $image;
    public $left;
    public $slide_id;

    /**
     * Create a new job instance.
     *
     * @param $text
     * @param $image
     * @param $left
     * @param $slide_id
     */
    public function __construct($text, $image, $left, $slide_id)
    {
        $this->text     = $text;
        $this->image    = $image;
        $this->left     = $left;
        $this->slide_id = $slide_id;
    }

    /**
     * Execute the job.
     *
     * @param SplitsRepository $splits
     * @param ImageHandler $handler
     */
    public function handle(SplitsRepository $splits, ImageHandler $handler)
    {
        if ($this->image)
            $this->image = $handler->uploadImage($this->image, 'splits');

        $split = $splits->createFromJob($this);
        $split->slides()->attach($this->slide_id);

    }
}
