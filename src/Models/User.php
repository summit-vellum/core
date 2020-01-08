<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function policies()
    {
        $policiesString = file_get_contents(storage_path('app/policies.json'));
        $policies = json_decode($policiesString, true);

        return collect($policies);
    }

    public function modules()
    {
        return $this->policies()->keys();
    }

    public function permissions($module)
    {
        return collect($this->policies()[$module]);
    }
}
