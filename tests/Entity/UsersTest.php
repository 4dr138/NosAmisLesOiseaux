<?php

namespace tests\Entity;

use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    public function testUsers()
    {
        $user = new Users();
        $user->setUsername('Adrien');
        $user->setPassword('Adrien');
        $user->setName('Dujardin');
        $user->setFirstname('Michel');
        $user->setmail('michel.dujardin@noa.fr');
        $user->setGodfatherCode('');
        $user->setRoles(['ROLE_AMATEUR']);


        $this->assertEquals('Adrien', $user->getUsername());
        $this->assertEquals('Adrien', $user->getPassword());
        $this->assertEquals('Dujardin', $user->getName());
        $this->assertEquals('Michel', $user->getFirstname());
        $this->assertEquals('michel.dujardin@noa.fr', $user->getMail());
        $this->assertEquals('', $user->getGodfatherCode());
        $this->assertEquals(['ROLE_AMATEUR'], $user->getRoles());


    }
}