<?php

namespace CPanelAPI\Email;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * List e-maill acoounts records
 * @package CPanelAPI\Email
 */
class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('email:list')
            ->setDescription('List all e-mail accounts records');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emails = $this->call($output, 'Email', 'listpopswithdisk');

        $table = new Table($output);
        $table->setHeaders(['E-mail', 'Disk Quota', 'Disk Usage', '%']);

        foreach ($emails as $email) {
            $table->addRow([
                $email->email,
                $email->diskquota,
                $email->diskused,
                $email->diskusedpercent
            ]);
        }

        $table->render();
    }
}
