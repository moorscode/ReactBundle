<?php

namespace Limenius\ReactBundle\DependencyInjection;

use Exception;
use Limenius\ReactRenderer\Twig\ComponentInterface;
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

        $container->setParameter('limenius_react.default_rendering', $defaultRendering);
        $container->setParameter('limenius_react.twig_function_prefix', $config['twig_function_prefix'] || '');
        $container->setParameter('limenius_react.dom_id_prefix', $config['dom_id_prefix'] || '');
        $container->setParameter('limenius_react.fail_loud', $config['serverside_rendering']['fail_loud']);
        $container->setParameter('limenius_react.trace', $config['serverside_rendering']['trace']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('twig.xml');

        $cache = $config['serverside_rendering']['cache'];
        $container->setParameter('limenius_react.cache_enabled', $cache['enabled']);
    }
}
