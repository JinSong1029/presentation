<?php

namespace App\Traits;


trait SectionOrdering
{

    public function scopeAppearanceOrder($query)
    {
        return $query->orderBy('additional','ASC')->orderBy('ordering', 'ASC');
    }
}