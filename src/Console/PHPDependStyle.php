<?php declare(strict_types=1);

namespace PHPDepend\App\Console;

use PHPDepend\App\Console\Helper\Matrix;
use Random\Randomizer;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class PHPDependStyle extends SymfonyStyle
{
	public function __construct(
		private OutputInterface $output,
		Input $input
	) {
		parent::__construct($input, $this->output);
	}
	public function createMatrix(): Matrix
	{
		return new Matrix($this->output, new Randomizer());
	}
}
