<?php

namespace App\Modules\Access\Models;

use App\Modules\Access\Events\UserCreating;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use EntrustUserTrait;
    public static $uploads_path = 'uploads/users/';


    protected $appends = [];

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dispatchesEvents = ['creating' => UserCreating::class];

    public function findForPassport($username)
    {
        return $this->where('phone', $username)->first();
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getNameAttribute($name)
    {
        return $name;
    }


    public function scopeAdmins($query)
    {
        $query->has('roles');
    }

    public function scopeUsers($query)
    {
        $query->has('roles', '<', 1);
    }


    public function toggleBlock()
    {
        $this->block = !$this->block;

        return $this;
    }


//    public function getPermsAttribute()
//    {
//        $perms = [];
//        if (empty($this->permissions)) {
//            if (!request()->is('api/*')) {
//                $roles = $this->roles;
//                foreach ($roles as $role) {
//                    $perms = array_merge($perms, $role->perms()->pluck('permissions.name')->toArray());
//                }
//            }
//            $this->permissions = $perms;
//            return $perms;
//        } else
//            return $this->permissions;
//    }

    public function toArray()
    {

        $to_array_attributes = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        foreach ($this->relations as $key => $relation) {
            $to_array_attributes[$key] = $relation;
        }
        foreach ($this->appends as $key => $append) {
            $to_array_attributes[$key] = $append;
        }
        return $to_array_attributes;
    }

    public function updateApiToken()
    {
        do {
            $apiToken = bin2hex(openssl_random_pseudo_bytes(30));
        } while (self::select('id')->where('api_token', $apiToken)->exists());
        $this->api_token = $apiToken;
        return $this;
    }

}

