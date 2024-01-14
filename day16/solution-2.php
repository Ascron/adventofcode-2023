<?php

declare(strict_types=1);

function moveBeam($map, &$energized, &$registered, $position, $direction) {

    $directionString = $direction[0] . ',' . $direction[1];
    if (isset($registered[$position[0]][$position[1]]) && in_array($directionString, $registered[$position[0]][$position[1]])) {
        return;
    }

    $registered[$position[0]][$position[1]][] = $directionString;

    while (true) {
        $position[0] += $direction[0];
        $position[1] += $direction[1];

        if ($position[0] < 0 || $position[0] >= count($map)) {
            return;
        }

        if ($position[1] < 0 || $position[1] >= count($map[$position[0]])) {
            return;
        }

        $energized[$position[0]][$position[1]] = true;

        switch ($map[$position[0]][$position[1]]) {
            case '/':
                // [0, 1] -> [-1, 0]
                // [1, 0] -> [0, -1]
                // [-1, 0] -> [0, 1]
                // [0, -1] -> [1, 0]
                moveBeam($map, $energized, $registered, $position, [-$direction[1], -$direction[0]]);
                return;
            case '\\':
                // [0, 1] -> [1, 0]
                // [1, 0] -> [0, 1]
                // [-1, 0] -> [0, -1]
                // [0, -1] -> [-1, 0]
                moveBeam($map, $energized, $registered, $position, [$direction[1], $direction[0]]);
                return;
            case '-':
                if (abs($direction[0]) !== 0) {
                    moveBeam($map, $energized, $registered, $position, [0, 1]);
                    moveBeam($map, $energized, $registered, $position, [0, -1]);
                    return;
                }
                break;
            case '|':
                if (abs($direction[1]) !== 0) {
                    moveBeam($map, $energized, $registered, $position, [-1, 0]);
                    moveBeam($map, $energized, $registered, $position, [1, 0]);
                    return;
                }
                break;
        }
    }
}

function getResult($map, $position, $direction) {
    $energized = [];
    $energized[$position[0]][$position[1]] = true;
    $registered = [];

    moveBeam($map, $energized, $registered, $position, $direction);

    $result = 0;
    foreach ($energized as $y => $line) {
        $result += count($line);
    }

    return $result;
}

function solution (array $input) {
    $map = [];

    foreach ($input as $line) {
        $map[] = str_split(trim($line));
    }

    $results = [];

    for ($y = 0; $y < count($map); $y++) {
        for ($x = 0; $x < count($map[$y]); $x++) {
            if ($y != 0 && $y != count($map) - 1) {
                if ($x != 0 && $x != count($map[$y]) - 1) {
                    continue;
                }
            }

            if ($y === 0) {
                $results[] = getResult($map, [$y, $x], [1, 0]);
            }
            if ($y === count($map) - 1) {
                $results[] = getResult($map, [$y, $x], [-1, 0]);
            }

            if ($x === 0) {
                $results[] = getResult($map, [$y, $x], [0, 1]);
            }

            if ($x === count($map[$y]) - 1) {
                $results[] = getResult($map, [$y, $x], [0, -1]);
            }
        }
    }

    return max($results);
}