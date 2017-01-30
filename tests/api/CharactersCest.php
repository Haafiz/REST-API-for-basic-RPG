<?php

use App\Models\Character;

class CharactersCest {

    public function _before(ApiTester $I) {
        
    }

    public function _after(ApiTester $I) {
        
    }

    // tests
    public function listCharacters(ApiTester $I) {
        $I->wantTo("List all characters");
        $I->sendGET("/characters");

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['message' => 'characters_list']);
        $I->seeResponseJsonMatchesJsonPath('$.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].name');
    }

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

    public function tryToSeeSpecificCharacterWithWrongCharacterId(ApiTester $I) {
        $characterId = 99999;

        $I->wantTo("Try to See Character with wrong/invalid Character ID");
        $I->sendGET("/characters/$characterId");

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(404);
    }

    public function createUserCharacter() {
        $user = User::first();

        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);

        $I->sendPOST(
                '/me', [
                    'name' => 'Nam1', 
                    'age' => 28,
                    'skilled_in' => 'sword fighting',
                    'user_id' => $user->id
                    ]
        );

        $I->seeResponseCodeIsJson();
        $I->seeResponseCodeIs(200);
        
        $I->seeResponseContainsJson(['message' => 'character_created']);
        $I->seeResponseJsonMatchesJsonPath('$.data.name');
        $I->seeResponseJsonMatchesJsonPath('$.data.age');
    }

    public function seeAuthenticatedUserCharacter() {
        $user = User::first();

        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);

        $I->wantTo('See Authenticated User Character');
        $I->sendGET('/me');

        $I->seeResponseCodeIsJson();
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['message' => 'character']);
        
        $I->seeResponseJsonMatchesJsonPath('$.data.name');
        $I->seeResponseJsonMatchesJsonPath('$.data.age');
        $I->seeResponseJsonMatchesJsonPath('$.data.experience');
    }
}
