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

class CharacterController extends Controller
{
    
    public function __construct(Character $model)
    {
        $this->model = $model;
    }
    /**
     * List System characters
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $characters = $this->model->getList();

        return [
            'message' => 'characters_list',
            'data' => $characters
        ];
    }
    
    public function show(Request $request, $characterId) {
        $character = $this->model->find($characterId);
        
        if(!$character){
            abort(404);
        }
        
        return [
            'message' => 'Character',
            'data' => $character
        ];
    }

}
