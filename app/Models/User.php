<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function scopeAllFor($query, $user)
    {
//        return $query->whereHas('roles', function ($q) use ($user){
//            $q->where('id', '=', 3);
//            if ( $user->hasRole('admin') ) {
//                $q->orWhere('id', '=', 2);
//            }
//        });
        return $query;
    }

    public function scopeExceptCurrent($query, $user)
    {
        return $query->where('id', '!=', $user->id);
    }

    public function scopeClients($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('id', '=', 3);
        });
    }

    public function scopeStaff($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('id', '=', 2);
        });
    }

    public function scopeNameOrder($query, $order)
    {
        return $query->orderBy('name', $order);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function presentations()
    {
        return $this->hasMany(Presentation::class, 'author_id');
    }

    public function activePresentation()
    {
        return $this->belongsTo(Presentation::class, 'presentation_id');
    }
}
