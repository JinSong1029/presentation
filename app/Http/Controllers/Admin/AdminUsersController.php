<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserHasBeenDeleted;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetUserListRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Jobs\CreateUserJob;
use App\Jobs\UpdateUserJob;
use App\Models\User;
use App\Models\User\Role;
use App\Models\User\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Input;
use Session;

class AdminUsersController extends Controller
{

    private $users;
    private $auth;
    private $redirect;

    /**
     * AdminUsersController constructor.
     * @param UserRepository $users
     * @param Guard $auth
     * @param Redirector $redirect
     */
    public function __construct(UserRepository $users, Guard $auth, Redirector $redirect)
    {
        $this->users = $users;
        $this->auth = $auth;
        $this->redirect = $redirect;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Role $role
     * @param Request $request
     * @return Response
     */
    public function index(Role $role, GetUserListRequest $request)
    {
        $sortBy = $request->get('sortBy');
        $direction = $request->get('order');
        $perPage = 10;

        $roles = $role->toSelect();
        $users = $this->users->getAll(compact('sortBy', 'direction', 'perPage'), $this->auth->user());

        return view('users.index', compact('users', 'roles', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Role $role
     * @param GetUserListRequest $request
     * @return Response
     */
    public function create(Role $role, GetUserListRequest $request)
    {
        $sortBy = $request->get('sortBy');
        $direction = $request->get('order');
        $perPage = 10;

        $roles = $role->toSelect();
        $users = $this->users->getAll(compact('sortBy', 'direction', 'perPage'), $this->auth->user());

        return view('users.index', compact('users', 'roles', 'request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest|Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request)
    {

        $user = $this->dispatchFrom(CreateUserJob::class, $request);

        return $this->redirect->to('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @param Role $role
     * @param GetUserListRequest $request
     * @return Response
     * @internal param User $userToEdit
     * @internal param int $id
     */
    public function edit(User $user, Role $role, GetUserListRequest $request)
    {
        $sortBy = $request->get('sortBy');
        $direction = $request->get('order');
        $perPage = 10;

        $roles = $role->toSelect();
        $users = $this->users->getAll(compact('sortBy', 'direction', 'perPage'), $this->auth->user());

        return view('users.index', compact('users', 'roles', 'request', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUserRequest|Request $request
     * @param User $user
     * @return Response
     * @internal param int $id
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $request['user'] = $user;

        $this->dispatchFrom(UpdateUserJob::class, $request);
        return $this->redirect->to('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     * @internal param int $id
     */
    public function destroy(User $user)
    {

        $this->users->deleteUserById($user->id);
        event(new UserHasBeenDeleted($user));

        return $this->redirect->to('users');
        //TODO make event listener
    }
}
