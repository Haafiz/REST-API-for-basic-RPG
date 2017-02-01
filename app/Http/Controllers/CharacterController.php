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

class CharacterController extends Controller
{
    
    public function __construct(CharacterRepository $repo)
    {
        $this->repo = $repo;
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
        $characters = $this->repo->getList();

        return [
            'message' => 'characters_list',
            'data' => $characters
        ];
    }
    
    /**
     * Show Character Record
     * 
     * @param  Request $request
     * @param  String  $characterId
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $characterId) 
    {
        $character = $this->repo->model->find($characterId);
        
        if(!$character) {
            abort(404);
        }
        
        return [
            'message' => 'Character',
            'data' => $character
        ];
    }

}
