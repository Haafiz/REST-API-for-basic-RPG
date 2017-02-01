<?php

namespace App\Repositories;

use App\Models\Fight;

/**
 * FightRepository having domain logic related to Fight
 *
 * @author haafiz
 */
class FightRepository {
    
    public function __construct(Fight $model){
        $this->model = $model;
    }
    
    /**
     * Get Fights by Character
     * 
     * @param Character $character
     * @return Collection
     */
    public function getFightsByCharacter($character) {
        return $character->fights();
    }
    
    public function validateFightInput($character, $opponent) {
        $errorArr = [];
        if (!$character) {
            $errorArr[] = [
                'error' => 'character_not_exist',
                'error_detail' => 'Fight Belongs to Characters so first create Character'
                ];
        }
        
        if(!$opponent){
            $errorArr[] = [
                'error' => 'invalid_opponent_id',
                'error_detail' => 'There is no charcter with this opponent ID'
                ];
        }
        
        if(count($errorArr)){
            $this->errors = $errorArr;
        } else {
            return true;
        }
    }
    
    public function createFight($characterId, $opponentId) {
        $fightPossibilities = ['won', 'lost', 'draw'];
        $fightStatus = $fightPossibilities[rand(0,2)];
        
        if($fightStatus === 'won' || $fightStatus === 'lost'){
            $experience = 2;
        } else {
            $experience = 1;
        }
        
        $fightArr = [
            'experience' => $experience,
            'character_id' => $characterId,
            'opponent_id' => $opponentId,
            'status' => $fightStatus
        ];
        
        return $this->model->create($fightArr);
    }
}
