<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Collector;

use Lexik\Bundle\DataLayerBundle\Collector\CollectorChain;

/**
 * CollectorChainTest
 */
class CollectorChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test default object
     */
    public function testNoCollectors()
    {
        $chain = new CollectorChain();

        $this->assertInternalType('array', $chain->getCollectors());
        $this->assertCount(0, $chain->getCollectors());
    }

    /**
     * test not default object
     */
    public function testWithCollectors()
    {
        $chain = new CollectorChain();

        $chain->addCollector($this->getMock('Lexik\Bundle\DataLayerBundle\Collector\CollectorInterface'));
        $this->assertInternalType('array', $chain->getCollectors());
        $this->assertCount(1, $chain->getCollectors());

        $chain->addCollector($this->getMock('Lexik\Bundle\DataLayerBundle\Collector\CollectorInterface'));
        $this->assertInternalType('array', $chain->getCollectors());
        $this->assertCount(2, $chain->getCollectors());
    }
}
