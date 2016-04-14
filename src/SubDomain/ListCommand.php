<?php

namespace CPanelAPI\SubDomain;

use CPanelAPI\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * List sub-domain records
 * @package CPanelAPI\SubDomain
 */
class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('subdomain:list')
            ->setDescription('List all sub-domain records');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $subdomains = $this->call($output, 'SubDomain', 'listsubdomains');

        $table = new Table($output);
        $table->setHeaders(['Sub-domain', 'Directory']);

        foreach ($subdomains as $subdomain) {
            $table->addRow([$subdomain->domain, $subdomain->basedir]);
        }

        $table->render();
    }
}
