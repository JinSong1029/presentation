<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Presentation\DefaultSections;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateDefaultJob extends Job implements SelfHandling
{

    private $name;
    private $position;

    public function __construct($name, $position)
    {
        $this->name = $name;
        $this->position = $position;
    }

    public function handle(DefaultSections $section)
    {
        $section->name = $this->name;
        $section->ordering = $this->position;
        $section->save();
    }
}
