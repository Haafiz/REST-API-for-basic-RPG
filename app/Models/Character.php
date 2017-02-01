<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{

    public function user() 
    {
        return $this->belongsToOne(config('user_model_path'));
    }

    public function fights() 
    {
        return $this->hasMany('App\Models\Fight', 'character_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'age', 'skilled_in', 'user_id'
    ];

}
