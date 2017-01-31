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
use App\Models\User;

class UserCharacterController extends Controller {

    public function __construct(Character $model) {
        $this->model = $model;
        $this->currentUser = JWTAuth::parseToken()->authenticate();
    }

    /**
     * List System characters
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $input = $request->all();
        $input['user_id'] = $this->currentUser->id;
        
        $validator = \Validator::make($input, $this->model->getValidationRules());
        if ($validator->fails()) {
            return new JsonResponse(
                    [
                        'errors' => $validator->errors()
                    ], Response::HTTP_BAD_REQUEST
            );
        }
        
        $this->model->create($input);

        return [
            'message' => 'character_created',
            'data' => $input
        ];
    }

    public function show(Request $request) {
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
