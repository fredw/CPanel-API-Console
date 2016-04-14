<?php

namespace CPanelAPI\MySQL\Database;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Create MySQL database
 * @package CPanelAPI\MySQL\Database
 */
class CreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mysql:database:create')
            ->setDescription('Create a new database');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the database name <comment>(without CPanel user prefix. Ex: test):</comment> ');
        $name = $helper->ask($input, $output, $question);

        $this->call($output, 'MysqlFE', 'createdb', [
            'db' => getenv('SSH_USER') . '_' . $name
        ]);
    }
}
