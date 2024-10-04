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
namespace PHPDepend\App\Service;

use PHPDepend\App\Call;
use PHPDepend\App\CallList;
use SplFileInfo;
use function file_get_contents;
use function json_decode;

class JsonReader
{
    public function render(SplFileInfo $path): CallList
    {
        $content = json_decode(file_get_contents($path->getRealPath()), true);

        $callList = CallList::fromCalls();
        foreach ($content['data'] as $jsonCall) {
            $callList = $callList->with(Call::fromArray($jsonCall));
        }

        return $callList;
    }
}
