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

namespace PHPDepend\App\Model;

use Iterator;

final class CallList implements Iterator
{
	/** @var Call[] */
	private array $calls;

	private function __construct(Call ...$calls)
	{
		$this->calls = $calls;
	}

	public static function fromCalls(Call ...$calls): self
	{
		return new self(...$calls);
	}

	public function with(Call $call): self
	{
		return new self(...array_merge($this->calls, [$call]));
	}

	/**
	 * @param callable $sorter
	 * @return self
	 */
	public function sorted(callable $sorter): self
	{
		$calls = $this->calls;
		usort($calls, $sorter);

		return new self(...$calls);
	}

	public function current(): Call
	{
		return current($this->calls);
	}

	public function next(): void
	{
		next($this->calls);
	}

	public function key(): int|null
	{
		return key($this->calls);
	}

	public function valid(): bool
	{
		return null !== $this->key();
	}

	public function rewind(): void
	{
		reset($this->calls);
	}
}
