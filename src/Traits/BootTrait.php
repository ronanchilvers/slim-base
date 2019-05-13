<?php

namespace App\Traits;

use PDO;
use Psr\Container\ContainerInterface;
use Ronanchilvers\Foundation\Facade\Facade;
use Ronanchilvers\Orm\Orm;

/**
 * Trait providing methods for booting the application
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
trait BootTrait
{
    /**
     * Boot the framework
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function boot(ContainerInterface $container)
    {
        // Configure facades
        Facade::setContainer($container);

        // Configure ORM
        Orm::setConnection($container->get(PDO::class));
    }
}
