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

class Call
{
	private function __construct(
		private ClassName  $callingClass,
		private MethodName $callingMethod,
		private ClassName  $calledClass,
		private MethodName $calledMethod,
	)
	{
	}

	/**
	 * @param array{
	 *   callingClass: string,
	 *   callingMethod: string,
	 *   calledClass: string,
	 *   calledMethod: string
	 * } $content
	 */
	public static function fromArray(array $content): self
	{
		return new self(
			ClassName::fromString($content['callingClass']),
			MethodName::fromString($content['callingMethod']),
			ClassName::fromString($content['calledClass']),
			MethodName::fromString($content['calledMethod']),
		);
	}

	public function getCallingClass(): ClassName
	{
		return $this->callingClass;
	}

	public function getCalledClass(): ClassName
	{
		return $this->calledClass;
	}

	public function getCallingMethod(): MethodName
	{
		return $this->callingMethod;
	}

	public function getCalledMethod(): MethodName
	{
		return $this->calledMethod;
	}
}
