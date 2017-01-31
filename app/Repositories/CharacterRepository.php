<?php

namespace App\Repositories;

use App\Models\Character;

/**
 * Description of FightRepository
 *
 * @author haafiz
 */
class CharacterRepository {
    
    public function __construct(Character $model){
        $this->model = $model;
    }
    
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
    
    /**
     * Get Characters List
     * 
     * @return Collection
     */
    public function getList(){
        return $this->model->select('id', 'name')->get();
    }
}
