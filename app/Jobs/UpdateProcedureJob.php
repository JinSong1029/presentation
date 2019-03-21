<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\SlideTypes\ProcedureRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateProcedureJob extends Job implements SelfHandling
{
    /**
     * @var
     */
    private $procedure;
    /**
     * @var
     */
    private $desc;
    /**
     * @var
     */
    private $label;

    /**
     * Create a new job instance.
     *
     * @param $procedure
     * @param $desc
     * @param $label
     */
    public function __construct($procedure, $desc, $label)
    {
        $this->procedure = $procedure;
        $this->desc      = $desc;
        $this->label     = $label;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->procedure->desc  = $this->desc;
        $this->procedure->label = $this->label;
        $this->procedure->update();

        return $this->procedure;
    }
}
