<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Functional;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * AppKernel
 */
class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Lexik\Bundle\DataLayerBundle\LexikDataLayerBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return sys_get_temp_dir().'/LexikDataLayerBundle/';
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return sys_get_temp_dir().'/LexikDataLayerBundle/';
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');
        if (self::VERSION_ID >= 34001 && self::VERSION_ID < 40000) {
            $loader->load(__DIR__.'/config/security34.yml');
        } else {
            $loader->load(__DIR__.'/config/security.yml');
        }
    }
}
