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
use App\Repositories\FightRepository;

class FightController extends Controller {

    public function __construct(FightRepository $repo) {
        $user = JWTAuth::parseToken()->authenticate();
        $this->character = $user->character()->first();
        $this->repo = $repo;
    }

    /**
     * List System characters
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $character = $this->character;
        if (!$character) {
            return JsonResponse(
                [
                'error' => 'character_not_exist',
                'error_detail' => 'Fight Belongs to Characters so first create Character'
                ], Response::HTTP_BAD_REQUEST
            );
        }

        $fights = $character->fights;
        
        return [
            'message' => 'fights_list',
            'data' => $fights
        ];
    }

    public function store(Request $request, Character $characterModel) {

        $character = $this->character;
        
        $opponentId = $request->get('opponent_id');
        $opponent = $characterModel->find($opponentId);
        
        if(!$this->repo->validateFightInput($character, $opponent)){
            return new JsonResponse($this->repo->errors, Response::HTTP_BAD_REQUEST);
        }
        
        $fight = $this->repo->createFight($character->id, $opponentId);
            
        return [
            'message' => 'fight_completed',
            'data' => $fight
        ];
    }

}
