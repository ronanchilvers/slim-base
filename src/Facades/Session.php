<?php

namespace App\Facades;

use Ronanchilvers\Foundation\Facade\Facade;

/**
 * Session facade class
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Session extends Facade
{
    /**
     * {@inheritdoc}
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected static function getFacadeName()
    {
        return 'session';
    }
}
