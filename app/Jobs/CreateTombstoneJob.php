<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\SlideTypes\Tombstone;
use App\Models\SlideTypes\TombstonesRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateTombstoneJob extends Job implements SelfHandling
{
    /**
     * @var
     */
    private $label;
    /**
     * @var
     */
    private $desc;
    /**
     * @var
     */
    private $image;
    /**
     * @var
     */
    private $slide_id;
    /**
     * @var
     */
    private $position;
    /**
     * @var
     */
    private $double;

    /**
     * Create a new job instance.
     *
     * @param $label
     * @param $desc
     * @param $image
     * @param $slide_id
     * @param $position
     * @param $double
     */
    public function __construct($label, $desc, $image, $slide_id,$position, $double)
    {
        //
        $this->label = $label;
        $this->desc = $desc;
        $this->image = $image;
        $this->slide_id = $slide_id;
        $this->position = $position;
        $this->double = $double;
    }

    /**
     * Execute the job.
     *
     * @param TombstonesRepository $tombstones
     * @param ImageHandler $imageHandler
     * @return Tombstone
     */
    public function handle(TombstonesRepository $tombstones, ImageHandler $imageHandler)
    {
        $image = $imageHandler->uploadImage($this->image,'tombstones');
        $tombstone = $tombstones->createTombstone($this->label,$this->desc,$image,$this->double);

        $tombstone->slides()->attach($this->slide_id);
        $tombstone->slides()->sync([$this->slide_id => ['position' => $this->position]], false);

        return $tombstone;
    }
}
