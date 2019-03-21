<?php

namespace App\Models\User;

use Zizaco\Entrust\EntrustRole;

class Role extends  EntrustRole
{
    public function toSelect()
    {
        return Role::lists('name', 'id');
    }
}