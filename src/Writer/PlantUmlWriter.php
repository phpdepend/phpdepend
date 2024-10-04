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

namespace PHPDepend\App\Writer;

use PHPDepend\App\Call;
use PHPDepend\App\CallList;
use PHPDepend\App\Writer\Writer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function fwrite;
use const PHP_EOL;

class PlantUmlWriter implements Writer
{
	public function __construct(
		private InputInterface  $input,
		private OutputInterface $output
	)
	{
	}

	public function write(CallList $list): void
	{
		$classes = [];
		$calls   = [];
		/** @var Call $item */
		foreach ($list as $item) {
			$classes[implode('.', $item->getCalledClass()->getNamespaceSplit())][$item->getCalledMethod()->getName()]   = true;
			$classes[implode('.', $item->getCallingClass()->getNamespaceSplit())][$item->getCallingMethod()->getName()] = true;
		}

		$handle = fopen($this->input->getOption('output'), 'wb+');

		fwrite($handle, '@startuml' . PHP_EOL);
		foreach ($classes as $class => $methods) {
			fwrite($handle, 'class ' . $class . '{' . PHP_EOL);
			foreach ($methods as $method => $yes) {
				fwrite($handle, '    ' . $method . '()' . PHP_EOL);
			}
			fwrite($handle, '}' . PHP_EOL);
		}

		foreach ($list as $item) {
			fwrite($handle,
				implode('.', $item->getCallingClass()->getNamespaceSplit()) .
				'::' .
				$item->getCallingMethod()->getName() .
				' --> ' .
				implode('.', $item->getCalledClass()->getNamespaceSplit()) .
				'::' .
				$item->getCalledMethod()->getName() .
				PHP_EOL
			);
		}

		fwrite($handle, '@enduml' . PHP_EOL);
		fclose($handle);
	}
}
