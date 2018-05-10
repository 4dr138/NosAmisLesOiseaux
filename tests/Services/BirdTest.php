<?php

namespace tests\Services;

use App\Entity\Bird;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BirdTest extends KernelTestCase
{
    /**
     * @var $taxrefCdName
     */
    private $taxrefCdName;


    protected function setUp()
    {
        self::bootKernel();
        $this->taxrefCdName = static::$kernel->getContainer()->get('appbundle.birds');
    }

    public function testGetExistingBird()
    {
        $obj = $this->taxrefCdName;
        $cdName = 441604;

        $result = $this->invokeMethod($obj, 'getExistingBird', array($cdName));
        $this->assertEquals(1775, $result);

    }


    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}