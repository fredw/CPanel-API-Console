<?php

namespace CPanelAPI\Crontab;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Create a crontab record
 * @package CPanelAPI\Crontab
 */
class CreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('crontab:create')
            ->setDescription('Create a new crontab record');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the crontab command: ');
        $command = $helper->ask($input, $output, $question);

        $question = new Question('Inform the DAY interval: ');
        $question->setValidator(function ($value) {
            if (!is_numeric($value) && $value != '*') {
                throw new \Exception('The value must be numeric or *');
            }
            return $value;
        });
        $day = $helper->ask($input, $output, $question);

        $question = new Question('Inform the HOUR interval: ');
        $question->setValidator(function ($value) {
            if (!is_numeric($value) && $value != '*') {
                throw new \Exception('The value must be numeric or *');
            }
            return $value;
        });
        $hour = $helper->ask($input, $output, $question);

        $question = new Question('Inform the MINUTE interval: ');
        $question->setValidator(function ($value) {
            if (!is_numeric($value) && $value != '*') {
                throw new \Exception('The value must be numeric or *');
            }
            return $value;
        });
        $minute = $helper->ask($input, $output, $question);

        $question = new Question('Inform the MONTH interval: ');
        $question->setValidator(function ($value) {
            if (!is_numeric($value) && $value != '*') {
                throw new \Exception('The value must be numeric or *');
            }
            return $value;
        });
        $month = $helper->ask($input, $output, $question);

        $question = new Question('Inform the WEEKDAY interval: ');
        $question->setValidator(function ($value) {
            if (!is_numeric($value) && $value != '*') {
                throw new \Exception('The value must be numeric or *');
            }
            return $value;
        });
        $weekday = $helper->ask($input, $output, $question);

        $this->call($output, 'Cron', 'add_line', [
            'command' => $command,
            'day' => $day,
            'hour' => $hour,
            'minute' => $minute,
            'month' => $month,
            'weekday' => $weekday
        ]);
    }
}
