<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'role_id', 'is_active', 'confirmed', 'confirmation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];




    public function role(){

        return $this->belongsTo('App\Role');

    }



    public function isAdmin(){

        if($this->role->name == 'admin'){

            return true;

        }

        return false;

    }

    public function stations(){
        return $this->hasMany('App\Station');
    }


    public function logs(){
        $this->hasMany('App\Log');
    }


}



