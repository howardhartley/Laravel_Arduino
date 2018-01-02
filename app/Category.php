<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $fillable = ['name'];



    public function stations(){
        return $this->belongsToMany('App\Station');
    }


    public function measures(){
        return $this->hasMany('App\Measure');
    }

}
