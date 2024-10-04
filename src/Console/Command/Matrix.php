<?php declare(strict_types=1);

namespace PHPDepend\App\Console\Command;

use PHPDepend\App\Service\JsonReader;
use PHPDepend\App\Writer\DependencyMatrixHTMLWriter;
use SplFileInfo;
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
			->addArgument(
				'path',
				InputArgument::REQUIRED,
				'The path to the CallMap-JSON file'
			)
			->addOption(
				'target',
				't',
				InputOption::VALUE_OPTIONAL,
				'The path to the output html file',
				'matrix.html'
			);
	}

	/**
	 * Creates the matrix html file
	 *
	 * @throws \Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$output->write('generating the matrix: ');

		$reader   = new JsonReader();
		$callList = $reader->render(new SplFileInfo($input->getArgument('path')));

		$writer = new DependencyMatrixHTMLWriter($input->getOption('target'));
		$writer->write($callList);

		$output->writeln('done');
		return Command::SUCCESS;
	}
}
