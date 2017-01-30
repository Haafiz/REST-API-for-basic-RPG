<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Exception\HttpResponseException;
use App\Models\Character;
use App\Models\Fight;

class CharacterController extends Controller {

    public function __construct(Fight $model) {
        $this->model = $model;
    }

    /**
     * List System characters
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $user = JWTAuth::parseToken()->authenticate();
        $character = $user->character();
        
        if (!$character) {
            return JsonResponse(
                [
                'error' => 'character_not_exist',
                'error_detail' => 'Fight Belongs to Characters so first create Character'
                ], Response::HTTP_BAD_REQUEST
            );
        }

        $fights = $character->fights();

        return [
            'message' => 'fights_list',
            'data' => $fights
        ];
    }

    public function store(Request $request, Character $characterModel) {
        $user = JWTAuth::parseToken()->authenticate();
        $character = $user->character();
        
        $errorArr = [];
        if (!$character) {
            $errorArr[] = [
                'error' => 'character_not_exist',
                'error_detail' => 'Fight Belongs to Characters so first create Character'
                ];
        }
        
        $opponentId = $request->get('opponent_id');
        if(!$opponentId){
            $errorArr[] = [
                'error' => 'no_opponent_id',
                'error' => 'No opponent ID provided, please provide opponent ID',
                ];
        }
        
        $opponent = $characterModel->find($opponentId);
        if(!$opponent){
            $errorArr[] = [
                'error' => 'invalid_opponent_id',
                'error_detail' => 'There is no charcter with this opponent ID'
                ];
        }
        
        if(count($errorArr)){
            return new JsonResponse($errorArr, Response::HTTP_BAD_REQUEST);
        }
        
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
        
        $this->model->create($fightArr);
            
        return [
            'message' => 'fight_completed',
            'data' => [
                'fight' => $fightArr
            ]
        ];
    }

}
