<?php

namespace MyOnlineStore\ReactBundle\DependencyInjection;

use Exception;
use MyOnlineStore\ReactRenderer\Twig\ComponentInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MyOnlineStoreReactExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $defaultRendering = match ($config['default_rendering']) {
            'server_side' => ComponentInterface::SERVER_SIDE_RENDERING,
            'client_side' => ComponentInterface::CLIENT_SIDE_RENDERING,
            default => ComponentInterface::SERVER_AND_CLIENT_SIDE_RENDERING,
        };

        $container->setParameter('myonlinestore_react.default_rendering', $defaultRendering);
        $container->setParameter('myonlinestore_react.twig_function_prefix', $config['twig_function_prefix'] || '');
        $container->setParameter('myonlinestore_react.dom_id_prefix', $config['dom_id_prefix'] || '');
        $container->setParameter('myonlinestore_react.fail_loud', $config['serverside_rendering']['fail_loud']);
        $container->setParameter('myonlinestore_react.trace', $config['serverside_rendering']['trace']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('twig.xml');

        $cache = $config['serverside_rendering']['cache'];
        $container->setParameter('myonlinestore_react.cache_enabled', $cache['enabled']);
    }
}
