<?php

namespace Paco\Bundle\CorsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('paco_cors');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode->children()
                    ->scalarNode('allowed_origin')
                        ->cannotBeEmpty()
                        ->info('The allowed HTTP origin. By default it equals the value of the Origin request header as defined by the value *.')
                        ->defaultValue('*')
                    ->end()    
                    ->scalarNode('allowed_methods')
                        ->cannotBeEmpty()
                        ->info('The coma separated list of all methods HTTP methods.')
                        ->defaultValue('*')
                    ->end()
                    ->scalarNode('allowed_headers')
                        ->cannotBeEmpty()
                        ->info('The coma separated list of all allowed HTTP headers.')
                        ->defaultValue('*')
                    ->end()
                    ->scalarNode('max_age')
                        ->info('The number of seconds the Preflight request must be cached, so the browser would not fire it on every request.')
                    ->end()
                    ->scalarNode('exposed_headers')
                        ->info('The coma separated list of additional headers you want the client to be aware of.')
                    ->end()
                 ->end();   

        return $treeBuilder;
    }
}
