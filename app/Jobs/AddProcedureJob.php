<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\SlideTypes\ProcedureRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class AddProcedureJob extends Job implements SelfHandling
{
    /**
     * @var
     */
    private $desc;
    /**
     * @var
     */
    private $label;
    /**
     * @var
     */
    private $slide_id;

    /**
     * Create a new job instance.
     *
     * @param $desc
     * @param $label
     * @param $slide_id
     */
    public function __construct($desc, $label,$slide_id)
    {
        $this->desc = $desc;
        $this->label = $label;
        $this->slide_id = $slide_id;
    }

    /**
     * Execute the job.
     *
     * @param ProcedureRepository $procedures
     */
    public function handle(ProcedureRepository $procedures)
    {
        $procedure = $procedures->create($this->desc,$this->label);
        $procedure->slides()->attach($this->slide_id);
    }
}
