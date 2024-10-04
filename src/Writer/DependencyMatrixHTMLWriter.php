<?php

namespace PHPDepend\App\Writer;

use PHPDepend\App\Model\CallList;
use PHPDepend\App\Writer\Writer;

class DependencyMatrixHTMLWriter implements Writer
{
	private string $target;

	/**
	 * matrix [ CLASS ][ CLASS ] INT
	 *
	 * @var array<string, array<string, int>>
	 */
	private array $matrix;

	/**
	 * classes[int] CLASS
	 *
	 * @var array<int, string>
	 */
	private array $classes;

	public function __construct(string $filePath)
	{
		$this->target = $filePath;
	}

	public function write(CallList $list): void
	{
		$this->loadData($list);

		$table = $this->generateTableHeader();

		foreach ($this->classes as $keyRow => $calling) {
			$table .= "<tr><th class=\"class-key-v\">$keyRow</th><th class=\"class-name\">$calling</th>";
			foreach ($this->classes as $keyCol => $called) {
				$table .= "<td class=\"heat " . ($keyRow == $keyCol?'diagonal ':'')
				       . $this->getCSSClass(($this->matrix[$calling][$called]?? 0))
				       . "\" title=\"" . $calling  . " " . $called . "\">"
				       . ($this->matrix[$calling][$called]?? 0) . "</td>";
			}
			$table .= "</tr>";
		}
		$table .= "</table>";

		$html = file_get_contents(__DIR__ . '/../../templates/dependency-matrix.html');

		file_put_contents($this->target, sprintf($html, $table));
	}

	private function loadData(CallList $list)
	{
		foreach ($list as $call) {
			if (empty($call->getCalledClass()->getFullClassName())) {
				continue;
			}
			if (!isset($this->matrix[$call->getCallingClass()->getFullClassName()][$call->getCalledClass()->getFullClassName()])) {
				$this->matrix[$call->getCallingClass()->getFullClassName()][$call->getCalledClass()->getFullClassName()] = 0;
			}
			$this->matrix[$call->getCallingClass()->getFullClassName()][$call->getCalledClass()->getFullClassName()]++;
			$this->classes[] = $call->getCallingClass()->getFullClassName();
			$this->classes[] = $call->getCalledClass()->getFullClassName();
		}

		$this->classes = array_unique($this->classes);
		sort($this->classes);
	}

	private function generateTableHeader(): string
	{
		$table = "<table class=\"matrix\">";
		$table .= "<tr><th></th><th></th>";
		foreach ($this->classes as $key => $header) {
			$table .= "<th class=\"class-key-h\">$key</th>";
		}
		$table .= "</tr>";

		return $table;
	}

	private function getCSSClass(int $amount): string
	{
		return "heat-" . ceil($amount / 10);
	}
}
