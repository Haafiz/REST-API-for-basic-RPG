<?php

use App\Models\Character;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class FightsCest
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
        
        $this->user = $user;
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * Test User's Fights listing
     * 
     * @param ApiTester $I
     */
    public function listFights(ApiTester $I)
    {
        /**
 * Setupfor this test 
*/
        factory('App\Models\Character')->create(['user_id' => $this->user->id]);
        
        $character = $this->user->character()->first();
        factory('App\Models\Fight', 3)->create(
            [
            'character_id' => $character->id
            ]
        );

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
    
    /**
     * Test an attempt to create a fight without having a character which should
     * return 400 (Bad Request)
     * 
     * @param ApiTester $I
     */
    public function tryToCreateFightWithoutCharacter(ApiTester $I)
    {
        $opponentId = Character::first()->id;
        
        $I->wantTo("Try to create Fight without having Character");
        $I->sendPOST("/me/fights", ['opponent_id' => $opponentId]);
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(400);
        
        $I->seeResponseContainsJson(['error'=>'character_not_exist']);
    }

    /**
     * Test Fight creation with valid input
     * 
     * @param ApiTester $I
     */
    public function createFight(ApiTester $I)
    {
        /**
         * Setupfor this test 
         */
        factory('App\Models\Character')->create(['user_id' => $this->user->id]);
        
        $opponentId = Character::first()->id;
        
        $I->wantTo("Create a Fight");
        $I->sendPOST("/me/fights", ['opponent_id' => $opponentId]);
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        
        $I->seeResponseContainsJson(['message'=>'fight_completed']);
        $I->seeResponseJsonMatchesJsonPath('$.data.character_id');
        $I->seeResponseJsonMatchesJsonPath('$.data.opponent_id');
    }
}
