<?php declare(strict_types=1);

namespace PHPDepend\App\Console\Helper;

use Random\Randomizer;
use Symfony\Component\Console\Output\OutputInterface;

final class Matrix
{
	private const CHAR_ARRAY = [
		"- ",
		"* ",
		"% ",
		"& ",
		"# ",
		"@ ",
		"1 ",
		"2 ",
		"3 ",
		"4 ",
		"5 ",
		"6 ",
		"7 ",
		"8 ",
		"9 ",
		"0 ",
		"ア",
		"ィ",
		"イ",
		"ゥ",
		"ウ",
		"ェ",
		"エ",
		"ォ",
		"オ",
		"カ",
		"ガ",
		"キ",
		"ギ",
		"ク",
		"グ",
		"ケ",
		"ゲ",
		"コ",
		"ゴ",
		"サ",
		"ザ",
		"シ",
		"ジ",
		"ス",
		"ズ",
		"セ",
		"ゼ",
		"ソ",
		"ゾ",
		"タ",
		"ダ",
		"チ",
		"ヂ",
		"ッ",
		"ツ",
		"ヅ",
		"テ",
	];

	private const COLOR_ARRAY = [
		"22",
		"28"
	];


	public function __construct(
		private OutputInterface $output,
		private Randomizer $randomizer
	) {
	}

	protected $lineArray;
	protected $lineCount = 750;
	protected $speed = 75000000;
	protected $screenWidth = 125;

	protected function buildLineArray()
	{
		for ($i=1; $i<=$this->screenWidth; $i++) {
			$this->lineArray[$i] = 1;
		}
	}

	public function render()
	{
		$this->setColorGreens();
		$this->clearScreen();
		$this->setTerminalWidth();
		$this->fillScreen();
		$this->buildLineArray();

		for ($l=1; $l<=$this->lineCount; $l++) {
			$this->writeLine();
		}

		$this->setColorClear();
	}

	public function stop(): void
	{
		$this->lineCount = 0;
	}

	protected function writeCharacter()
	{
		$this->output->write(self::CHAR_ARRAY[$this->randomizer->getInt(0, 52)]);
	}

	protected function writeLine()
	{
		foreach ($this->lineArray as $key => $line) {
			if ($line == 1 || $line == 2) {

				if ($line == 2) {
					$this->setColorLightGreen();
					$this->writeCharacter();
					$this->lineArray[$key] = 1;
					$this->setColorGreens();
				} else {
					$this->writeCharacter();
				}

				$rand = $this->randomizer->getInt(1, 30);

				if ($rand == 1) {
					$this->lineArray[$key] = 0;
				}

			} else {
				$this->output->write("  ");
				$randTwo = $this->randomizer->getInt(1, 60);

				if ($randTwo == 1) {
					$this->lineArray[$key] = 2;
				}
			}
		}

		$this->output->write("\r");
		$this->output->write("\033[T\033[A");
		time_nanosleep(0, $this->speed);
	}

	protected function clearScreen()
	{
		$this->output->write("\033\143");
	}

	protected function fillScreen()
	{
		for ($l=1; $l<=50; $l++) {
			for ($i=1; $i<=$this->screenWidth; $i++) {
				$this->output->write(self::CHAR_ARRAY[$this->randomizer->getInt(0, 52)]);
			}

			$this->output->write("\r");
			$this->output->write("\033[T\033[A");
		}
	}

	protected function setColorClear()
	{
		$this->output->write("\033[0m");
	}

	protected function setColorLightGreen()
	{
		$this->output->write("\033[38;5;15m");
	}

	protected function setColorGreens()
	{
		$colorCode = self::COLOR_ARRAY[$this->randomizer->getInt(0, 1)];
		$this->output->write("\033[38;5;".$colorCode."m");
	}

	protected function setTerminalWidth()
	{
		$this->screenWidth = system("tput cols");
	}
}
