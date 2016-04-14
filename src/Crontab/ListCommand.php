<?php

namespace CPanelAPI\Crontab;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * List crontab records
 * @package CPanelAPI\Crontab
 */
class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('crontab:list')
            ->setDescription('List all crontab records');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $crontabs = $this->call($output, 'Cron', 'fetchcron');

        $table = new Table($output);
        $table->setHeaders(['Line', 'Linekey', 'Day', 'Hour', 'Minute', 'Month', 'Weekday', 'Command']);

        foreach ($crontabs as $crontab) {
            if (!isset($crontab->type) || $crontab->type != 'command') {
                continue;
            }
            $table->addRow([
                $crontab->line,
                $crontab->linekey,
                $crontab->day,
                $crontab->hour,
                $crontab->minute,
                $crontab->month,
                $crontab->weekday,
                $crontab->command
            ]);
        }

        $table->render();
    }
}
