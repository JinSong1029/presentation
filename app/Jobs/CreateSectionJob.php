<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Presentation;
use App\Models\presentation_id;
use App\Models\Section;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateSectionJob extends Job implements SelfHandling
{

    private $name;
    private $position;
    private $presentation_id;

    public function __construct($name, $position,$presentation_id)
    {
        $this->name = $name;
        $this->position = $position;
        $this->presentation_id = $presentation_id;
    }

    public function handle(Section $section)
    {

        $section->name = $this->name;
        $section->ordering = $this->position;
        $section->presentation_id = $this->presentation_id;
        $section->save();

    }
}
