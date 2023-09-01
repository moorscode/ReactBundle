<?php

namespace Limenius\ReactBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class LimeniusReactExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('limenius_react.default_rendering', $config['default_rendering']);
        $container->setParameter('limenius_react.fail_loud', $config['serverside_rendering']['fail_loud']);
        $container->setParameter('limenius_react.trace', $config['serverside_rendering']['trace']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('twig.xml');

        $defaultRendering = $config['default_rendering'];

        if ('both' === $defaultRendering || 'server_side' === $defaultRendering) {
            $rendererFactory = $container->getDefinition('limenius_react.render_factory');

            if ($serverSocketPath = $config['serverside_rendering']['server_socket_path']) {
                $rendererFactory->addMethodCall('setServerSocketPath', array($serverSocketPath));
            }

            if ($serverBundlePath = $config['serverside_rendering']['server_bundle_path']) {
                $rendererFactory->addMethodCall('setServerBundlePath', array($serverBundlePath));
            }
        }

        $cache = $config['serverside_rendering']['cache'];
        $container->setParameter('limenius_react.cache_enabled', $cache['enabled']);
        if ($cache['enabled']) {
            $container->setParameter('limenius_react.cache_key', $cache['key']);
        }
    }
}
