<?php

namespace MyOnlineStore\ReactBundle;

use MyOnlineStore\ReactBundle\DependencyInjection\Compiler\CacheCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * The React Bundle class.
 */
class MyOnlineStoreReactBundle extends Bundle
{
    /**
     * Adds the cache compiler pass.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new CacheCompilerPass());
    }
}
