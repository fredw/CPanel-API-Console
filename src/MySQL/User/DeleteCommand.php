<?php

namespace CPanelAPI\MySQL\User;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Delete MySQL user
 * @package CPanelAPI\MySQL\User
 */
class DeleteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mysql:user:delete')
            ->setDescription('Delete an user');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the user name (without CPanel user prefix. Ex: test): ');
        $user = $helper->ask($input, $output, $question);

        $this->call($output, 'MysqlFE', 'deletedbuser', [
            'dbuser' => getenv('SSH_USER') . '_' . $user
        ]);
    }
}
