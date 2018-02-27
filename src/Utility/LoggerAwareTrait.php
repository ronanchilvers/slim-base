<?php

namespace App\Utility;

use Psr\Log\LoggerInterface;

/**
 * Trait for objects that are logger aware
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
trait LoggerAwareTrait
{
    /**
     * @var Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Set the Logger
     *
     * @param Psr\Log\LoggerInterface $logger
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get the Logger object
     *
     * @return Psr\Log\LoggerInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function logger()
    {
        return $this->logger;
    }
}
