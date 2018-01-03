<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    protected $fillable= [
        'category_id', 'station_id', 'collection', 'value'
    ];




    public function station(){
        return $this->belongsTo('App\Station');
    }



    public function category(){
        return $this->belongsTo('App\Category');
    }



     public function symbol(){
            $cat = $this->category->name;

            if($cat == 'Θερμοκρασία'){
                return '&#8451;';
            }
        }





    }


