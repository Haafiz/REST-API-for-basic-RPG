<?php

use App\Models\Character;

class CharactersCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function listFights(ApiTester $I)
    {
            
        $I->wantTo("List all fights");
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
    
    public function tryToshowSpecificCharacterWithWrongCharacterId(ApiTester $I)
    {
        $characterId = 99999;
        
        $I->wantTo("Try to Show Character with wrong/invalid Character ID");
        $I->sendGET("/characters/$characterId");
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(404);
    }
}
