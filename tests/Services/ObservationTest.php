<?php

namespace tests\Services;

use App\Entity\Observation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ObservationTest extends KernelTestCase
{
    /**
     * @var $userId
     */
    private $userId;


    protected function setUp()
    {
        self::bootKernel();
        $this->userId = static::$kernel->getContainer()->get('appbundle.observations');
    }

    public function testGetObservationByUser()
    {
        $obj = $this->userId;
        $userId = 53;
        $observation1 = new Observation();
        $observation1->setId(46);
        $observation1->setLatitude('45.764043');
        $observation1->setLongitude('4.8356589999');
        $observation1->setComment('LyonPivert');
        $observation1->setBird(3352);
        $observation1->setBirdName('Pic vert, Pivert');
        $observation1->setUser($userId);
        $observation1->setDateObservation(new \DateTime('09-05-2018'));
        $observation1->setUpdatedAt(null);

        $observation2 = new Observation();
        $observation2->setId(45);
        $observation2->setLatitude('48.856614');
        $observation2->setLongitude('2.3522219');
        $observation2->setComment('Test');
        $observation2->setBird(1777);
        $observation2->setBirdName('Autour australien, Émouchet gris');
        $observation2->setUser($userId);
        $observation2->setDateObservation(new \DateTime('09-05-2018'));
        $observation2->setUpdatedAt(null);



        $result = $this->invokeMethod($obj, 'getObservationsById', array($userId));
        $this->assertEquals([$observation1, $observation2], $result);

    }


    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}