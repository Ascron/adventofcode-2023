<?php

declare(strict_types=1);

function moveFrom($position, $direction, $map, &$pathCache, &$result, $maxY, $maxX) {
    $heat = 0;
    foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] as $step) {
        $newPosition = [$position[0] + $direction[0] * $step, $position[1] + $direction[1] * $step];
        if (!isset($map[$newPosition[0]][$newPosition[1]])) {
            continue;
        }
        $heat += $map[$newPosition[0]][$newPosition[1]];
        if ($step < 4) {
            continue;
        }

        if (abs($direction[0]) === 1) {
            // vertical move
            $newPath = $pathCache[$position[0]][$position[1]]['v'] + $heat;
            $oldDistance = $pathCache[$newPosition[0]][$newPosition[1]]['h'] ?? null;
            $pathCache[$newPosition[0]][$newPosition[1]]['h'] ??= $newPath;

            if ($newPath >= $result) {
                continue;
            }

            $pathCache[$newPosition[0]][$newPosition[1]]['h'] = min(
                $newPath,
                $pathCache[$newPosition[0]][$newPosition[1]]['h']
            );

            if ($newPosition[0] === $maxY && $newPosition[1] === $maxX) {
                $result = min($newPath, $result);
                continue;
            }

            if ($newPath > $pathCache[$newPosition[0]][$newPosition[1]]['h'] || $oldDistance === $newPath) {
                continue;
            }

            moveFrom($newPosition, [0, 1], $map, $pathCache, $result, $maxY, $maxX);
            moveFrom($newPosition, [0, -1], $map, $pathCache, $result, $maxY, $maxX);
        } else {
            // horizontal move
            $newPath = $pathCache[$position[0]][$position[1]]['h'] + $heat;
            $oldDistance = $pathCache[$newPosition[0]][$newPosition[1]]['v'] ?? null;
            $pathCache[$newPosition[0]][$newPosition[1]]['v'] ??= $newPath;

            if ($newPath >= $result) {
                continue;
            }

            $pathCache[$newPosition[0]][$newPosition[1]]['v'] = min(
                $newPath,
                $pathCache[$newPosition[0]][$newPosition[1]]['v']
            );

            if ($newPosition[0] === $maxY && $newPosition[1] === $maxX) {
                $result = min($newPath, $result);
                continue;
            }

            if ($newPath > $pathCache[$newPosition[0]][$newPosition[1]]['v'] || $newPath === $oldDistance) {
                continue;
            }

            moveFrom($newPosition, [1, 0], $map, $pathCache, $result, $maxY, $maxX);
            moveFrom($newPosition, [-1, 0], $map, $pathCache, $result, $maxY, $maxX);
        }
    }
}

function solution (array $input) {
    $map = [];
    foreach ($input as $line) {
        $map[] = str_split(trim($line));
    }

    $position = [0, 0];
    $pathCache = [];
    $pathCache[$position[0]][$position[1]] = [
        'h' => 0,
        'v' => 0
    ];

    $maxY = max(array_keys($map));
    $maxX = max(array_keys($map[0]));

    $result = PHP_INT_MAX;

    moveFrom($position, [0, 1], $map, $pathCache, $result, $maxY, $maxX);
    moveFrom($position, [1, 0], $map, $pathCache, $result, $maxY, $maxX);

    return $result;
}