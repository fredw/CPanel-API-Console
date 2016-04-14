<?php

namespace CPanelAPI\Crontab;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Delete a crontab record
 * @package CPanelAPI\Crontab
 */
class DeleteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('crontab:delete')
            ->setDescription('Delete a crontab record');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the crontab line to delete: ');
        $question->setValidator(function ($value) {
            if (!is_numeric($value)) {
                throw new \Exception('The value must be numeric');
            }
            return $value;
        });
        $line = $helper->ask($input, $output, $question);

        $this->call($output, 'Cron', 'remove_line', [
            'line' => $line
        ]);
    }
}
