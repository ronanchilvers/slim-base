<?php

namespace App\Console;

use App\Utility\ContainerAwareTrait;
use Symfony\Component\Console\Application as BaseApplication;

/**
 * Base console application
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Application extends BaseApplication
{
    use ContainerAwareTrait;

    /**
     * Get the container object
     *
     * @return Psr\Container\ContainerInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getContainer()
    {
        return $this->container;
    }
}
