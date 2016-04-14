<?php

namespace CPanelAPI\SubDomain;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Create a sub-domain record
 * @package CPanelAPI\SubDomain
 */
class CreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('subdomain:create')
            ->setDescription('Create a new sub-domain');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Inform the sub-domain name (example: static): ');
        $name = $helper->ask($input, $output, $question);

        $question = new Question('Inform the directory (default: public_html): ', 'public_html');
        $directory = $helper->ask($input, $output, $question);

        $this->call($output, 'SubDomain', 'addsubdomain', [
            'domain' => $name,
            'rootdomain' => getenv('DOMAIN'),
            'dir' => $directory
        ]);
    }
}
