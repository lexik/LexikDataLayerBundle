<?php

namespace Lexik\Bundle\DataLayerBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * CollectorCompilerPass
 */
class CollectorCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('lexik_data_layer.collector.collector_chain')) {
            return;
        }

        $definition = $container->findDefinition('lexik_data_layer.collector.collector_chain');
        $taggedServices = $container->findTaggedServiceIds('lexik_data_layer.collector');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addCollector', [new Reference($id)]);
        }
    }
}
