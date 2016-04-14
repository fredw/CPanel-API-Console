<?php

namespace CPanelAPI\MySQL\User;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * List MySQL users
 * @package CPanelAPI\MySQL\User
 */
class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mysql:user:list')
            ->setDescription('List all users');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->call($output, 'MysqlFE', 'listusers');
        //var_dump($users); exit;

        $table = new Table($output);
        $table->setHeaders(['User', 'Databases']);

        foreach ($users as $user) {
            $table->addRow([
                $user->user,
                implode(', ', array_map(function ($database) { return $database->db; }, $user->dblist))
            ]);
        }

        $table->render();
    }
}
