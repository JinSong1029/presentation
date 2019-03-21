<?php

namespace App\Models\User;

use App\Models\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll(array $params)
    {
        if ( $this->isSortable($params) ) {
            return $this->user->orderBy($params['sortBy'], $params['direction'])->paginate($params['perPage']);
        }

        return $this->user->paginate($params['perPage']);
    }


    public function createUser($name, $password)
    {
        $this->user->name = $name;
        $this->user->password = $password;
        $this->user->password_open = $password;
        $this->user->save();
        return $this->user;
    }

    public function updateUser($user,$name,$password)
    {
        $user->name = $name;
        $user->password = $password;
        $user->password_open = $password;
        $user->update();

        return $user;
    }
    public function deleteUserById($id)
    {
        $this->user->destroy([$id]);
    }
}