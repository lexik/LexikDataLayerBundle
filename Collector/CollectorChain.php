<?php

namespace Lexik\Bundle\DataLayerBundle\Collector;

/**
 * CollectorChain
 */
class CollectorChain
{
    /**
     * @var CollectorInterface[]
     */
    protected $collectors;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->collectors = [];
    }

    /**
     * @param CollectorInterface $collector
     */
    public function addCollector(CollectorInterface $collector)
    {
        $this->collectors[] = $collector;
    }

    /**
     * @return CollectorInterface[]
     */
    public function getCollectors()
    {
        return $this->collectors;
    }
}
