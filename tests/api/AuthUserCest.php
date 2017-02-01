<?php

use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

class AuthUserCest
{
    /**
     * Setting up user authentication related stuff before running test
     * 
     * @param ApiTester $I
     */
    public function _before(ApiTester $I)
    {
        $user = User::first();
     
        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * Test getting current authenticated User info.
     * 
     * @param ApiTester $I
     */
    public function getCurrentAuthenticatedUser(ApiTester $I)
    {
        $I->wantTo("See Current Authenticated User's info ");
        $I->sendGET('/auth/user');
        
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'authenticated_user']);
        $I->seeResponseJsonMatchesJsonPath('$.data.id');
        $I->seeResponseJsonMatchesJsonPath('$.data.name');
        $I->seeResponseJsonMatchesJsonPath('$.data.email');
   }
}
