<?php declare(strict_types=1);

namespace PHPDepend\App\Console;

use PHPDepend\App\Info;
use PHPDepend\App\Service\JsonReader;
use PHPDepend\App\Writer\WriterFactory;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
{
	public function __construct()
	{
		parent::__construct('PHPDepend', Info::VERSION);

		$this->setDefaultCommand('list');
		$this->silenceXDebug();
	}

	public function getDefaultCommands(): array
	{
		$symfonyDefaults = parent::getDefaultCommands();

		return array_merge(
			array_slice($symfonyDefaults, 0, 2),
			[
				new Command\Matrix(),
				new Command\Graph(new JsonReader(), new WriterFactory())
			]
		);
	}

	/**
	 * Append release date to version output
	 *
	 * @return string
	 */
	public function getLongVersion(): string
	{
		return sprintf(
			'<info>%s</info> version <comment>%s</comment> %s <fg=blue>#StandWith</><fg=yellow>Ukraine</>',
			$this->getName(),
			$this->getVersion(),
			Info::RELEASE_DATE
		);
	}

	/**
	 * Make sure X-Debug does not interfere with the exception handling
	 *
	 * @return void
	 *
	 * @codeCoverageIgnore
	 */
	private function silenceXDebug(): void
	{
		if (function_exists('ini_set') && extension_loaded('xdebug')) {
			ini_set('xdebug.show_exception_trace', '0');
			ini_set('xdebug.scream', '0');
		}
	}
}
