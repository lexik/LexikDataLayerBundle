<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Service;

use Lexik\Bundle\DataLayerBundle\Collector\CollectorChain;
use Lexik\Bundle\DataLayerBundle\Collector\CollectorInterface;
use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * DataLayerManagerTest
 */
class DataLayerManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test get method
     */
    public function testGet()
    {
        $session = new Session(new MockArraySessionStorage());
        $manager = new DataLayerManager($session, new CollectorChain());

        $this->assertEquals([], $manager->all());
    }

    /**
     * test get method
     */
    public function testAdd()
    {
        $session = new Session(new MockArraySessionStorage());
        $manager = new DataLayerManager($session, new CollectorChain());
        $manager->add(['goal' => true]);

        $this->assertEquals([['goal' => true]], $manager->all());
    }

    /**
     * test get method
     */
    public function testCollectorChainUsage()
    {
        $session = new Session(new MockArraySessionStorage());
        $manager = new DataLayerManager($session, $this->getCollectorChainMock());

        $this->assertEquals([], $manager->all());
    }

    /**
     * @return CollectorChain
     */
    private function getCollectorChainMock()
    {
        $collectorChainMock = $this
            ->getMockBuilder('Lexik\Bundle\DataLayerBundle\Collector\CollectorChain')
            ->getMock();

        $collectorChainMock
            ->expects($this->once())
            ->method('getCollectors')
            ->will($this->returnValue([$this->getCollectorMock()]));

        return $collectorChainMock;
    }

    /**
     * @return CollectorInterface
     */
    private function getCollectorMock()
    {
        $collectorMock = $this
            ->getMockBuilder('Lexik\Bundle\DataLayerBundle\Collector\UserIdCollector')
            ->disableOriginalConstructor()
            ->getMock();

        $collectorMock
            ->expects($this->once())
            ->method('handle');

        return $collectorMock;
    }
}
