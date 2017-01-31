<?php

use App\Repositories\CharacterRepository;
use App\Models\Character;
use Illuminate\Support\Collection;

class CharacterTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function testGetCharacterValidationRules()
    {
        $characterModel = new Character;
        
        $characterRepo = new CharacterRepository($characterModel);
        $characters = $characterRepo->getValidationRules();
        
        $this->assertArrayHasKey('name', $characters);
        $this->assertArrayHasKey('age', $characters);
        $this->assertArrayHasKey('skilled_in', $characters);
    }
}
