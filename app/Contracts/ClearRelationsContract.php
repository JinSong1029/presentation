<?php

namespace App\Contracts;


interface ClearRelationsContract
{
    /**
     * Delete all related objects.
     * @return mixed
     */
    public function clearRelated();

}