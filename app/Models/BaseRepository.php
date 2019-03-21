<?php

namespace App\Models;


class BaseRepository
{
    public function isSortable(array $params)
    {
        return $params['sortBy'] and $params['direction'];
    }
}