<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateTeamJob extends Job implements SelfHandling
{


    private $team;
    private $label;
    private $desc;
    private $image;
    /**
     * @var
     */
    private $double;

    public function __construct($team, $label, $desc, $image, $double)
    {
        $this->team = $team;
        $this->label = $label;
        $this->desc = $desc;
        $this->image = $image;
        $this->double = $double;
    }

    public function handle(ImageHandler $imageHandler)
    {

        $this->image = $imageHandler->checkForUpdate($this->team, $this->image, 'teams');

        $this->team->label = $this->label;
        $this->team->desc = $this->desc;
        $this->team->image = $this->image;
        $this->team->double = $this->double;

        $this->team->update();

        return $this->team;
    }
}
