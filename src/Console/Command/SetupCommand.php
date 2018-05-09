<?php

namespace App\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Setup the development environment
 *
 * This command has to:
 *  - create a new .env file in the site root
 *      - configure the session key
 *  - setup the db.config.php file in the site root
 *      - database credentials
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class SetupCommand extends Command
{
    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function configure()
    {
        $this
            ->setName('setup')
            ->setDescription('Setup the application for the first time');
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('setting up your environment');

        $output->writeln('done');
    }
}
