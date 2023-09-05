<?php

namespace Limenius\ReactBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * The compiler pass to set the cache key.
 */
class CacheCompilerPass implements CompilerPassInterface
{
    /**
     * Processes the build.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->getParameter('limenius_react.cache_enabled')) {
            return;
        }

        $appCache = $container->findDefinition('cache.app');
        $key = $container->getParameter('limenius_react.cache_key');

        $container
            ->getDefinition('limenius_react.render_extension')
            ->addMethodCall('setCache', [$appCache, $key]);
    }
}
