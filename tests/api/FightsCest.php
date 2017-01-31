<?php

use App\Models\Character;
use App\Models\User;

class FightsCest
{
    public function _before(ApiTester $I)
    {
        $user = User::first();

        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);
        
        $this->user = $user;
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function listFights(ApiTester $I)
    {
        factory('App\Models\Character')->create(['user_id' => $this->user->id]);
        
        $I->wantTo("List all my fights");
        $I->sendGET("/me/fights");
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        
        $I->seeResponseContainsJson(['message'=>'fights_list']);
        
        $I->seeResponseJsonMatchesJsonPath('$.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].character_id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].opponent_id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].status');
    }
    
    public function tryToCreateFightWithoutCharacter(ApiTester $I)
    {
        $opponentId = Character::first();
        
        $I->wantTo("Show Character with Character ID");
        $I->sendGET("/characters/$opponentId");
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        
        $I->seeResponseContainsJson(['message'=>'Character']);
        $I->seeResponseJsonMatchesJsonPath('$.data.id');
        $I->seeResponseJsonMatchesJsonPath('$.data.name');
        $I->seeResponseJsonMatchesJsonPath('$.data.age');
    }
}
