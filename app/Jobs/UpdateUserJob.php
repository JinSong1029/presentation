<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User\UserRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateUserJob extends Job implements SelfHandling
{

    private $password;
    private $user;
    private $roles;
    private $name;

    public function __construct($user, $name, $password)
    {
        $this->password = $password;
        $this->user = $user;
        $this->name = $name;
    }


    public function handle(UserRepository $repo)
    {
        $user = $repo->updateUser($this->user, $this->name, $this->password);

        $user->roles()->detach();
        $user->attachRole($this->roles);
    }
}
