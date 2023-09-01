<?php

namespace Limenius\ReactBundle;

use Limenius\ReactBundle\DependencyInjection\Compiler\CacheCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * The React Bundle class.
 */
class LimeniusReactBundle extends Bundle
{
    /**
     * Adds the cache compiler pass.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CacheCompilerPass());
    }
}
