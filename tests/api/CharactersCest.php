<?php

use App\Models\Character;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class CharactersCest {

    public function _before(ApiTester $I) {
        
    }
 
   public function _after(ApiTester $I) {
        
    }

    /**
     * List Characters Endpoint test
     * 
     * @param ApiTester $I
     */
    public function listCharacters(ApiTester $I) {
        $I->wantTo("List all characters");
        $I->sendGET("/characters");

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['message' => 'characters_list']);
        $I->seeResponseJsonMatchesJsonPath('$.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].name');
    }

    /**
     * See Single Character using Character ID test
     * 
     * @param ApiTester $I
     */
    public function seeSpecificCharacter(ApiTester $I) {
        $characterId = Character::first()->id;

        $I->wantTo("See Character with Character ID");
        $I->sendGET("/characters/$characterId");

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['message' => 'Character']);
        $I->seeResponseJsonMatchesJsonPath('$.data.id');
        $I->seeResponseJsonMatchesJsonPath('$.data.name');
        $I->seeResponseJsonMatchesJsonPath('$.data.age');
    }

    /**
     * Try See Specific Chracter while using Wrong Character ID which should 
     * provide 404
     * 
     * @param ApiTester $I
     */
    public function tryToSeeSpecificCharacterWithWrongCharacterId(ApiTester $I) {
        $characterId = 99999;

        $I->wantTo("Try to See Character with wrong/invalid Character ID");
        $I->sendGET("/characters/$characterId");

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(404);
    }

    /**
     * Test Creation of User Character as Authenitcated User
     * 
     * @param ApiTester $I
     */
    public function createUserCharacter(ApiTester $I) {
        $user = User::first();

        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);

        $I->wantTo("Create Character as Authnticated User");
        
        $I->sendPOST(
                '/me', [
                    'name' => "Haafiz",
                    'age' => rand(13,80),
                    'skilled_in' => "Sword Fighting"
                    ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        
        $I->seeResponseContainsJson(['message' => 'character_created']);
        $I->seeResponseJsonMatchesJsonPath('$.data.name');
        $I->seeResponseJsonMatchesJsonPath('$.data.age');
    }

    /**
     * Testing See Authenticated User's Character
     * 
     * @param ApiTester $I
     */
    public function seeAuthenticatedUserCharacter(ApiTester $I) {
        $user = User::first();
        
        factory('App\Models\Character')->create(['user_id' => $user->id]);
        
        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);

        $I->wantTo('See my Character as Authenticated User');
        $I->sendGET('/me');

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['message' => 'character']);
        
        $I->seeResponseJsonMatchesJsonPath('$.data.name');
        $I->seeResponseJsonMatchesJsonPath('$.data.age');
    }
}
