<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model {

    public function user() {
        return $this->belongsToOne('App\Models\User');
    }

    public function fights() {
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

    /**
     * Validation Rules for creating Character
     *
     * @var array 
     */
    protected static $validationRules = [
        'name' => 'required|min:2',
        'age' => 'required|Integer',
        'skilled_in' => 'required',
        'user_id' => 'required|unique:characters'
    ];

    /**
     * Get Validation Rules
     * 
     * @return Array Associative Array
     */
    public function getValidationRules() {
        return static::$validationRules;
    }

}
