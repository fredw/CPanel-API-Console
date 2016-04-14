<?php

namespace CPanelAPI\MySQL\Permission;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Delete user previleges
 * @package CPanelAPI\MySQL\User
 */
class DeleteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mysql:permission:delete')
            ->setDescription('Delete user previleges');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the e user name <comment>(without CPanel user prefix. Ex: test):</comment> ');
        $user = $helper->ask($input, $output, $question);

        $question = new Question('Inform the database name <comment>(without CPanel user prefix. Ex: test):</comment> ');
        $database = $helper->ask($input, $output, $question);

        $this->call($output, 'MysqlFE', 'revokedbuserprivileges', [
            'dbuser' => getenv('SSH_USER') . '_' . $user,
            'db' => getenv('SSH_USER') . '_' . $database
        ]);
    }
}
