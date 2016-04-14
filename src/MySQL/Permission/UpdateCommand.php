<?php

namespace CPanelAPI\MySQL\Permission;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Update user previleges
 * @package CPanelAPI\MySQL\User
 */
class UpdateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mysql:permission:update')
            ->setDescription('Define or update user previleges to a database');
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

        $question = new ChoiceQuestion(
            'Inform the previleges: ',
            [
                'ALL PRIVILEGES',
                'ALTER',
                'ALTER ROUTINE',
                'CREATE',
                'CREATE ROUTINE',
                'CREATE TEMPORARY TABLES',
                'CREATE VIEW',
                'DELETE',
                'DROP',
                'EVENT',
                'EXECUTE',
                'INDEX',
                'INSERT',
                'LOCK TABLES',
                'REFERENCES',
                'SELECT',
                'SHOW VIEW',
                'TRIGGER',
                'UPDATE'
            ]
        );
        $previleges = $helper->ask($input, $output, $question);

        $this->call($output, 'MysqlFE', 'setdbuserprivileges', [
            'dbuser' => getenv('SSH_USER') . '_' . $user,
            'db' => getenv('SSH_USER') . '_' . $database,
            'privileges' => is_array($previleges) ? implode(',', $previleges) : $previleges
        ]);
    }
}
