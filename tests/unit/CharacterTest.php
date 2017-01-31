<?php

use App\Models\Character;
use Illuminate\Support\Collection;

class CharacterTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->character = Mockery::mock('App\Models\Character[getList]');
    }

    protected function tearDown()
    {
    }

    // tests
    public function testGetCharacterList()
    {
        $character = new Character;
        $characters = $character->getValidationRules();
        
        $this->assertInstanceOf(Collection::class, $characters);
    }
}
