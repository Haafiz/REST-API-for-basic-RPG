<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Exception\HttpResponseException;
use App\Repositories\CharacterRepository;
use App\User;

class UserCharacterController extends Controller
{

    public function __construct(CharacterRepository $repo) 
    {
        $this->repo = $repo;
        $this->currentUser = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Create User Character
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        $input = $request->all();
        $input['user_id'] = $this->currentUser->id;
        
        $validator = \Validator::make($input, $this->repo->getValidationRules());
        if ($validator->fails()) {
            return new JsonResponse(
                [
                        'errors' => $validator->errors()
                    ], Response::HTTP_BAD_REQUEST
            );
        }
        
        $this->repo->model->create($input);

        return [
            'message' => 'character_created',
            'data' => $input
        ];
    }

    /**
     * Show User Character
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) 
    {
        $character = $this->currentUser->character()->first();
        if (!$character) {
            return new JsonResponse(
                [
                        'error' => 'charactar_not_exist',
                        'error_detail' => 'No Character Exist for this User, first create Character'
                    ], Response::HTTP_BAD_REQUEST
            );
        }

        return [
            'message' => 'character',
            'data' => $character
        ];
    }

}
