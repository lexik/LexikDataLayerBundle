<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Functional\Collector;

use Lexik\Bundle\DataLayerBundle\Tests\Functional\TestCase;

/**
 * CollectorChainTest
 */
class CollectorChainTest extends TestCase
{
    /**
     * test tagged collectors are correctly injected into the collector chain
     */
    public function testCollectorChainIsNotEmpty()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $chain = $kernel->getContainer()->get('lexik_data_layer.collector.collector_chain');
        $this->assertCount(1, $chain->getCollectors());
    }
}
