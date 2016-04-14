<?php

namespace CPanelAPI\Email;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Delete a e-mail record
 * @package CPanelAPI\Email
 */
class DeleteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('email:delete')
            ->setDescription('Delete an e-mail record');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the domain (ex: domain.com): ');
        $domain = $helper->ask($input, $output, $question);

        $question = new Question('Inform the e-mail account to delete (ex: user): ');
        $email = $helper->ask($input, $output, $question);

        $this->call($output, 'Email', 'delpop', [
            'domain' => $domain,
            'email' => $email
        ]);
    }
}
