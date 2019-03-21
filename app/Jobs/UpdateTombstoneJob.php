<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateTombstoneJob extends Job implements SelfHandling
{


    private $tombstone;
    private $label;
    private $desc;
    private $image;
    /**
     * @var
     */
    private $double;

    public function __construct($tombstone, $label, $desc, $image, $double)
    {
        $this->tombstone = $tombstone;
        $this->label = $label;
        $this->desc = $desc;
        $this->image = $image;
        $this->double = $double;
    }

    public function handle(ImageHandler $imageHandler)
    {

        $this->image = $imageHandler->checkForUpdate($this->tombstone, $this->image, 'tombstones');

        $this->tombstone->label = $this->label;
        $this->tombstone->desc = $this->desc;
        $this->tombstone->image = $this->image;
        $this->tombstone->double = $this->double;

        $this->tombstone->update();

        return $this->tombstone;
    }
}
