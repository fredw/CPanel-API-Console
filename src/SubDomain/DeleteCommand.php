<?php

namespace CPanelAPI\SubDomain;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Delete sub-domain record
 * @package CPanelAPI\SubDomain
 */
class DeleteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('subdomain:delete')
            ->setDescription('Delete a sub-domain');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the domain name (ex: static.domain.com.br): ');
        $domain = $helper->ask($input, $output, $question);

        $this->call($output, 'SubDomain', 'delsubdomain', [
            'domain' => $domain
        ]);
    }
}
