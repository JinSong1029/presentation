<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Repositories\SplitsRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateSplitJob extends Job implements SelfHandling
{
    public $screen;
    public $text;
    public $image;
    public $left;
    public $type;
    public $use_presentation_color;
    private $detachedImageId;

    /**
     * Create a new job instance.
     *
     * @param $screen
     * @param $text
     * @param $image
     * @param $left
     * @param $type
     * @param $use_presentation_color
     * @param $detachedImageId
     */
    public function __construct($screen, $text, $image, $left, $type, $use_presentation_color,$detachedImageId)
    {

        $this->screen = $screen;
        $this->type   = explode(',', $type);
        $this->text   = in_array('text', $this->type) ? $text : null;
        $this->image  = $image;
        $this->left   = $left;
        $this->use_presentation_color = $use_presentation_color;
        $this->detachedImageId = $detachedImageId;
    }

    /**
     * Execute the job.
     *
     * @param SplitsRepository $splits
     * @param ImageHandler $handler
     */
    public function handle(SplitsRepository $splits, ImageHandler $handler)
    {
        if ($this->screen->image && !in_array('image', $this->type)) {
            $handler->deleteImage($this->screen->image, 'splits');
            $this->image = null;
        } else {
            $this->image = $handler->checkForUpdate($this->screen, $this->image, 'splits');

            if ($this->detachedImageId) {
                $handler->deleteImage($this->screen->image, 'splits');
                $this->image = null;
            }

        }
        $updatedSplit = $splits->updateFromJob($this->screen, $this);

        return $updatedSplit;
    }
}
