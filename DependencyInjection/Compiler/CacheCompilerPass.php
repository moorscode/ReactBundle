<?php

namespace MyOnlineStore\ReactBundle\DependencyInjection\Compiler;

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
        if (!$container->getParameter('myonlinestore_react.cache_enabled')) {
            return;
        }

        $appCache = $container->findDefinition('cache.app');

        $container
            ->getDefinition('myonlinestore_react.render_extension')
            ->addMethodCall('setCache', [$appCache]);
    }
}
