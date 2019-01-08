<?php

namespace App\Facades;

use Psr\Log\LoggerInterface;
use Ronanchilvers\Foundation\Facade\Facade;

/**
 * Session facade class
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Log extends Facade
{
    /**
     * {@inheritdoc}
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected static function getFacadeName()
    {
        return LoggerInterface::class;
    }
}
