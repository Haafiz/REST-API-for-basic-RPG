<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$api = $app->make(Dingo\Api\Routing\Router::class);

$api->version(
    'v1', function ($api) {
        $api->post(
            '/auth/login', [
                'as' => 'api.auth.login',
                'uses' => 'App\Http\Controllers\Auth\AuthController@login',
            ]
        );

        $api->group(
            [
            'middleware' => ['parseToken', 'api.auth'],
            ], function ($api) {
                $api->get(
                    '/', [
                        'uses' => 'App\Http\Controllers\APIController@getIndex',
                        'as' => 'api.index'
                    ]
                );

                /* Authentication and authenticated user related endpoints */
                $api->group(
                    [
                    'namespace' => 'App\Http\Controllers\Auth',
                    'prefix' => 'auth'
                    ], function ($api) {
                        $api->get(
                            'user', [
                                'uses' => 'AuthController@getUser',
                                'as' => 'api.auth.user'
                            ]
                        );
                        $api->patch(
                            '/', [
                                'uses' => 'AuthController@refreshToken',
                                'as' => 'api.auth.refresh'
                            ]
                        );
                        $api->delete(
                            '/', [
                                'uses' => 'AuthController@invalidateToken',
                                'as' => 'api.auth.invalidate'
                            ]
                        );
                    }
                );

                /* Game specific routes */
                $api->resource(
                    'characters', 'CharacterController', ['only' => [
                        'index', 'show'
                    ]]
                );

                $api->resource(
                    'me/fights', 'FightController@index', ['only' => [
                        'index', 'create'
                    ]]
                );

                $api->resource(
                    '/me', 'UserCharacterController', ['only' => [
                        'store', 'show'
                    ]]
                );

            }
        );
    }
);
