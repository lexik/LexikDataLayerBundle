<?php

namespace Lexik\Bundle\DataLayerBundle\Manager;

use Lexik\Bundle\DataLayerBundle\Collector\CollectorChain;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * DataLayerManager
 */
class DataLayerManager
{
    const KEY = 'lexik_data_layer';

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var CollectorChain
     */
    protected $collectorChain;

    /**
     * @param SessionInterface $session
     * @param CollectorChain   $collectorChain
     */
    public function __construct(SessionInterface $session, CollectorChain $collectorChain)
    {
        $this->session = $session;
        $this->collectorChain = $collectorChain;
    }

    /**
     * Add data to the data layer.
     *
     * @param array $data ['data_name' => 'data_value']
     */
    public function add(array $data)
    {
        $current = $this->session->get(self::KEY, []);
        $current[] = $data;

        $this->session->set(self::KEY, $current);
    }

    /**
     * Get data layer data.
     *
     * @return array [['data_name' => 'data_value']]
     */
    public function all()
    {
        $data = $this->session->get(self::KEY, []);

        foreach ($this->collectorChain->getCollectors() as $collector) {
            $collector->handle($data);
        }

        return $data;
    }

    /**
     * Reset data layer value.
     */
    public function reset()
    {
        $this->session->remove(self::KEY);
    }
}
