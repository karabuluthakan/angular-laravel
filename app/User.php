<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email', 'role_id', 'avatar_id', 'password', 'remember_token', 'created_at', 'updated_at', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;

    private $perms = [];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function permissions()
    {
        return $this->hasMany('App\UserPermission');
    }

    public function setPerms(array $perms = [])
    {
        $_perms = [];
        foreach ($this->permissions as $perm) {
            $_permissions[$perm->name] = $perm;
        }

        foreach ($perms as $key => $value) {
            if (isset($_perms[$key])) {
                $_perms[$key]->can_do = $value;
                $_perms[$key]->save();
            } else {
                $this->permissions()->create([
                    'user_id' => $this->id,
                    'name'    => $key,
                    'can_do'  => $value
                ]);
            }
        }

        unset($_perms, $perms, $perm, $key, $value);
    }

    public function perms()
    {
        $_perms = [];
        $_perms[$this->role->name] = true;
        foreach ($this->role->permissions as $perm) {
            $_perms[$perm->name] = (bool)$perm->can_do;
        }

        foreach ($this->permissions as $perm) {
            $_perms[$perm->name] = (bool)$perm->can_do;
        }

        $this->perms = $_perms;
        unset($_perms, $perm);

        return $this->perms;
    }

    public function hasPerm($perm)
    {
        if (empty($this->perms))
            $this->perms();

        return isset($this->perms[$perm]) ? $this->perms[$perm] : false;
    }

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
}
