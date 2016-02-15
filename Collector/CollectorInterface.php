<?php

namespace Lexik\Bundle\DataLayerBundle\Collector;

/**
 * CollectorInterface
 */
interface CollectorInterface
{
    /**
     * Modify the Data Layer array
     *
     * @param array &$data
     *
     * @return mixed
     */
    public function handle(&$data);
}
