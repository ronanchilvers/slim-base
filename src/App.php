<?php

namespace App;

use DI\Bridge\Slim\App as DIApp;
use DI\ContainerBuilder;

/**
 * Local application subclass
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class App extends DIApp
{
    /**
     * {@inheritdoc}
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions(__DIR__ . '/../config/settings.php');
    }
}
