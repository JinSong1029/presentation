<?php

namespace App\Models\SlideTypes;


class ProcedureRepository
{
    /**
     * @var Procedure
     */
    private $procedure;

    /**
     * ProcedureRepository constructor.
     * @param Procedure $procedure
     */
    public function __construct(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }

    /**
     * @param $desc
     * @param $label
     * @return Procedure
     */
    public function create($desc, $label)
    {
        $this->procedure->desc  = $desc;
        $this->procedure->label = $label;

        $this->procedure->save();

        return $this->procedure;
    }
}