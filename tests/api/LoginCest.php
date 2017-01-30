<?php

use Illuminate\Support\Facades\Artisan;

class LoginCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function loginUsingCredentials(ApiTester $I)
    {
        $I->wantTo("Login using Credentials");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('/auth/login', ['email' => 'kaasib@gmail.com', 'password' => 'Haafiz']);
        
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'token_generated']);
        $I->seeResponseJsonMatchesJsonPath('$.data.token');
    }

    // tests
    public function loginUsingWrongCredentials(ApiTester $I)
    {   
        $I->wantTo("Try to Login using wrong Credentials and expect to be failed");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('/auth/login', ['email' => 'kaasib@gmail.com', 'password' => 'wrong password']);
        
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'invalid_credentials']);
    }
}
