<?php

namespace tests\Entity;
use App\Entity\Observation;
use PHPUnit\Framework\TestCase;

class ObservationTest extends TestCase
{
    public function testObservations()
    {
        $observation = new Observation();
        $observation->setLatitude('48.862725');
        $observation->setLongitude('2.287592');
        $observation->setComment('Observation');
        $observation->setBird(462);
        $observation->setUser(50);
        $observation->setBirdName('Pic vert, Pivert');


        $this->assertEquals('48.862725', $observation->getLatitude());
        $this->assertEquals('2.287592', $observation->getLongitude());
        $this->assertEquals('Observation', $observation->getComment());
        $this->assertEquals(462, $observation->getBird());
        $this->assertEquals(50, $observation->getUser());
        $this->assertEquals('Pic vert, Pivert', $observation->getBirdName());



    }
}