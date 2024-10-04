<?php declare(strict_types=1);

namespace PHPDepend\App\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Matrix extends Command
{
    protected function configure(): void
    {
        $this->setName('matrix')
             ->setDescription('creates dependency matrix')
             ->setHelp('creates dependency matrix')
             ->addOption(
                 'target',
                 't',
                 InputOption::VALUE_OPTIONAL,
                 'The path to the output html file'
             );
    }

    /**
     * Execute the command
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('generating the matrix');
        return 0;
    }
}