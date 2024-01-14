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

function solution (array $input) {
    $map = [];

    foreach ($input as $line) {
        $map[] = str_split(trim($line));
    }

    $direction = [0, 1];
    $position = [0, 0];
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