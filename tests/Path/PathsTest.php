<?php
namespace tests\Paths;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PathsTest extends WebTestCase

{
    public function testPathHomepage()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPathActualites()
    {
        $client = static::createClient();
        $client->request('GET', '/actualites');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPageContact()
    {
        // No form submitted
        $client = static::createClient();
        $client->request('GET', '/contact');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testPageConnexion()
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}