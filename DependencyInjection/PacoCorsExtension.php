<?php

namespace Paco\Bundle\CorsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PacoCorsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);


        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        //die(var_dump($config['origin']));

        $container->setParameter('paco_cors.allowed_origin', $config['allowed_origin']);
        $container->setParameter('paco_cors.allowed_methods', $config['allowed_methods']);
        $container->setParameter('paco_cors.allowed_headers', $config['allowed_headers']);
        $container->setParameter('paco_cors.max_age', $config['max_age']);
        $container->setParameter('paco_cors.exposed_headers', $config['exposed_headers']);

    }
}
