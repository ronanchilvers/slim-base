<?php

namespace App\Utility;

use App\Utility\ContainerAwareTrait;
use App\Utility\LoggerAwareTrait;
use App\Utility\TwigAwareTrait;

/**
 * Trait to provide some convenienve methods for controllers
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
trait ControllerTrait
{
    use ContainerAwareTrait;
    use LoggerAwareTrait;
    use TwigAwareTrait;

    /**
     * Get the session object
     *
     * @return Ronanchilvers\Sessions\Session
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function session()
    {
        return $this->container()->get('session');
    }
}
