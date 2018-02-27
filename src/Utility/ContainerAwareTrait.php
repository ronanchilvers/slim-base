<?php

namespace App\Utility;

use DI\Container;

/**
 * Trait for objects that are container aware
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
trait ContainerAwareTrait
{
    /**
     * @var DI\Container
     */
    private $container;

    /**
     * Set the container
     *
     * @param DI\Container $container
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get the container object
     *
     * @return DI\Container
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function container()
    {
        return $this->container;
    }
}
