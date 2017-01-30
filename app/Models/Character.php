<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model {

    public function user() {
        return $this->belongsToOne('App\Models\User');
    }

    public function fights() {
        return $this->hasMany('App\Models\Fight', 'user_character_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'age', 'attack_ability', 'defense_ability'
    ];
    
    public function getList() {
        return $this->select('id', 'name')->get();
    }
    
    
    
    
}
