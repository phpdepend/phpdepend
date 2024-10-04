<?php declare(strict_types=1);
/**
 * Copyright (C) 2023  Andreas Heigl<andreas@heigl.org>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace PHPDepend\App\Console\Command;

use PHPDepend\App\Service\JsonReader;
use PHPDepend\App\Writer\WriterFactory;
use PHPDepend\App\Writers;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Graph extends Command
{
	public function __construct(
		private JsonReader    $reader,
		private WriterFactory $writerFactory
	)
	{
		parent::__construct();
	}

	protected function configure()
	{
		$this->setName('graph')
			->setDescription('Render a plantuml file from a CallMap-JSON File')
			->addOption('target', 't', InputOption::VALUE_REQUIRED, 'Where to write the output to', 'callmap.plantuml')
			->addArgument('path', InputArgument::REQUIRED, 'The path to the CallMap-JSON file');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$callList = $this->reader->render(new SplFileInfo($input->getArgument('path')));
		$this->writerFactory->getWriter(Writers::PlantUML, $input, $output)->write($callList);

		return Command::SUCCESS;
	}
}
