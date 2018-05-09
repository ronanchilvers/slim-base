<?php

namespace App\Console\Command;

use Defuse\Crypto\Key;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;


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
        $helper = $this->getHelper('question');
        $filename = realpath(__DIR__ . '/../../../') . '/.env';

        if (file_exists($filename)) {
            $output->writeln('!! ' . $filename . ' already exists!');
            if (!$helper->ask(
                $input,
                $output,
                new ConfirmationQuestion('are you sure you want to regenerate it? (y/N)', false)
            )) {
                $output->writeln('ok - aborting as requested');
                return;
            }
            $output->writeln('ok - carrying on with regenerating your config file...');
        }

        $output->writeln('setting up your environment');
        $output->writeln('generating session key');

        $config = [
            'displayErrorDetails' => 'true',
            'encryption.key'      => null,
            'database.dsn'        => '<db dsn here>',
            'database.username'   => '<db user name here>',
            'database.password'   => '<db password here>',
        ];

        $sessionKey = Key::createNewRandomKey();
        $config['encryption.key'] = $sessionKey->saveToAsciiSafeString();

        $question = new ConfirmationQuestion('would you like to setup a database connection? (y/N) ', true);
        if ($helper->ask($input, $output, $question)) {
            $output->writeln('- setting up database connection');
            $questions = [
                'database.dsn'      => new Question('please give the PDO DSN for your database connection : '),
                'database.username' => new Question('please give the username for your connection (if needed):'),
                'database.password' => (new Question('please give the password for your connection (if needed):'))->setHidden(true),
            ];
            foreach ($questions as $key => $question) {
                $config[$key] = $helper->ask($input, $output, $question);
            }
        } else {
            $output->writeln('- skipping database connection');
        }

        $output->writeln('writing environment configuration to ' . $filename);
        $contents = [
            '; Config created on'
        ];
        foreach ($config as $key => $value) {
            $contents[] = "{$key} = {$value}";
        }
        $contents = implode("\n", $contents) . "\n";
        if (false === file_put_contents($filename, $contents)) {
            $output->writeln('!! unable to create config file - sorry!');
        }

        $output->writeln('done');
    }
}

