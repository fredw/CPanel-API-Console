<?php

namespace CPanelAPI\Email;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Create an email account
 * @package CPanelAPI\Email
 */
class CreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('email:create')
            ->setDescription('Create a new e-mail account');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the domain <comment>(ex: domain.com):</comment> ');
        $domain = $helper->ask($input, $output, $question);

        $question = new Question('Inform the account name <comment>(ex: john):</comment> ');
        $name = $helper->ask($input, $output, $question);

        $question = new Question('Inform the password for this account: ');
        $password = $helper->ask($input, $output, $question);

        $question = new Question('Inform the quota for this account (in MB): ');
        $question->setValidator(function ($value) {
            if ($value && (!is_numeric($value) || $value < 0)) {
                throw new \Exception('The value must be numeric');
            }
            return $value;
        });
        $quota = $helper->ask($input, $output, $question);

        $this->call($output, 'Email', 'addpop', [
            'domain' => $domain,
            'email' => $name,
            'password' => $password,
            'quota' => $quota
        ]);
    }
}
