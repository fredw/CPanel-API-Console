<?php

namespace CPanelAPI\MySQL\Database;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * List MySQL databases
 * @package CPanelAPI\MySQL\Database
 */
class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mysql:database:list')
            ->setDescription('List all databases');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $databases = $this->call($output, 'MysqlFE', 'listdbs');

        $table = new Table($output);
        $table->setHeaders(['Database', 'Size (MB)', 'Users']);

        foreach ($databases as $database) {
            $table->addRow([
                $database->db,
                $database->sizemeg,
                implode(', ', array_map(function ($user) { return $user->user; }, $database->userlist))
            ]);
        }

        $table->render();
    }
}
