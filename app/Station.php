<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{

    protected $fillable = [
        'unique', 'name', 'user_id', 'is_active', 'is_private', 'description', 'location'
    ];



    public function user(){
        return $this->belongsTo('App\User');
    }


    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public function measures(){
        return $this->hasMany('App\Measure');
    }



}
