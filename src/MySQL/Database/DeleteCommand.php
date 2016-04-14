<?php

namespace CPanelAPI\MySQL\Database;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Delete MySQL database
 * @package CPanelAPI\MySQL\Database
 */
class DeleteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mysql:database:delete')
            ->setDescription('Delete a database');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the database name (without CPanel user prefix. Ex: test): ');
        $name = $helper->ask($input, $output, $question);

        $this->call($output, 'MysqlFE', 'deletedb', [
            'db' => getenv('SSH_USER') . '_' . $name
        ]);
    }
}
