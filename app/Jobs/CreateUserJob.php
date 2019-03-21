<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User\UserRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateUserJob extends Job implements SelfHandling
{
    private $name;
    private $password;


    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }


    public function handle(UserRepository $repo)
    {

        $user = $repo->createUser($this->name, $this->password);
        $user->attachRole(1);
        return $user;
    }
}
