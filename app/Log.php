<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //

    protected $fillable = [ 'goodtobad', 'note', 'user_id'];




    public function user(){
        $this->belongsTo('App\User');
    }

}
