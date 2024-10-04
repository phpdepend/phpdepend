<?php declare(strict_types=1);

namespace PHPDepend\App\Console\Command;

use PHPDepend\App\Console\PHPDependStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
			->addArgument('path', InputArgument::REQUIRED, 'The path to the CallMap-JSON file')
			->addOption(
				'target',
				't',
				InputOption::VALUE_OPTIONAL,
				'The path to the output html file',
				'matrix.html'
			);
	}

	/**
	 * Execute the command
	 *
	 * @param \Symfony\Component\Console\Input\InputInterface   $input
	 * @param \Symfony\Component\Console\Output\OutputInterface $output
	 * @return int
	 * @throws \Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$io = new PHPDependStyle($output, $input);
		$io->writeln('generating the matrix');
		$matrix = $io->createMatrix();
		$matrix->render();
		$matrix->stop();
		return Command::SUCCESS;
	}
}
