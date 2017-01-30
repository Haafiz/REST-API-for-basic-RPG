<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fight extends Model
{

    public function character()
    {
        $this->belongsTo('App\Models\Character');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'character_id', 'opponent_id', 'status', 'experience_points'
    ];
    
    public function getFightsByCharacter($character) {
        return $character->fights();
    }
}
