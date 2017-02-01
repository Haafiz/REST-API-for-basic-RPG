<?php

use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

class AuthTokenCest
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
        
        $this->token = $token;
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * Test Authentication Refresh
     * 
     * @param ApiTester $I
     */
    public function refreshAuthenticationToken(ApiTester $I)
    {
        $I->wantTo("Refresh Authentication Token");
        $I->sendPATCH('/auth');
        
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'token_refreshed']);
        $I->seeResponseJsonMatchesJsonPath('$.data.token');
        
        $token = $I->grabDataFromResponseByJsonPath('$.data.token');
        
        $I->assertNotEquals($token, $this->token);
    }
    
    /**
     * Test Invalidating authentication
     * 
     * @param ApiTester $I
     */
    public function invalidateAuthenticationToken(ApiTester $I)
    {
        $I->wantTo("Invalidate Authentication Token");
        $I->sendDelete('/auth');
        
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'token_invalidated']);
        
        $I->amBearerAuthenticated($this->token);
        $I->sendGet('/auth/user');
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["message" => "The token has been blacklisted","status_code" => 401]);
    }
}
