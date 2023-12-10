<?php

declare(strict_types=1);

function moveThruPipe($pipeType, $fromPoint, $thruPoint, $pipes) {
    $enterMovement = [];
    foreach ($thruPoint as $index => $point) {
        $enterMovement[] = $fromPoint[$index] - $thruPoint[$index];
    }

    $possibleMovements = $pipes[$pipeType];
    foreach ($possibleMovements as $index => $movement) {
        if ($movement === $enterMovement) {
            unset($possibleMovements[$index]);
        }
    }

    if (count($possibleMovements) === 1) {
        $exitMovement = reset($possibleMovements);
        $exitPoint = [];
        foreach ($thruPoint as $index => $point) {
            $exitPoint[$index] = $thruPoint[$index] + $exitMovement[$index];
        }
        return $exitPoint;
    }

    return null;
}

function solution (array $input) {
    $startX = 0;
    $startY = 0;
    foreach ($input as $y => $line) {
        $hasStart = false;
        if (str_contains($line, 'S')) {
            $hasStart = true;
        }
        $input[$y] = str_split(trim($line));

        if ($hasStart) {
            foreach ($input[$y] as $x => $value) {
                if ($value === 'S') {
                    $startX = $x;
                    $startY = $y;
                }
            }
        }
    }

    /**
     * | is a vertical pipe connecting north and south.
     * - is a horizontal pipe connecting east and west.
     * L is a 90-degree bend connecting north and east.
     * J is a 90-degree bend connecting north and west.
     * 7 is a 90-degree bend connecting south and west.
     * F is a 90-degree bend connecting south and east.
     * . is ground; there is no pipe in this tile.
     * S is the starting position of the animal;
     */

    $pipes = [
        '|' => [
            [-1, 0], [1, 0]
        ],
        '-' => [
            [0, -1], [0, 1]
        ],
        'L' => [
            [-1, 0], [0, 1]
        ],
        'J' => [
            [-1, 0], [0, -1]
        ],
        '7' => [
            [0, -1], [1, 0]
        ],
        'F' => [
            [0, 1], [1, 0]
        ],
        'S' => [
            [-1, 0], [0, -1], [0, 1], [1, 0]
        ],
    ];

    $distance = 0;
    $currentPosition = [$startY, $startX];
    $connectedPipe = null;

    $possibleMovements = [
        [-1, 0], [0, -1], [0, 1], [1, 0]
    ];

    foreach ($possibleMovements as $movement) {
        if (!isset($input[$startY + $movement[0]][$startX + $movement[1]])) {
            continue;
        }

        $pipeType = $input[$startY + $movement[0]][$startX + $movement[1]];
        if (!array_key_exists($pipeType, $pipes)) {
            continue;
        }

        if (moveThruPipe($pipeType, [$startY, $startX], [$startY + $movement[0], $startX + $movement[1]], $pipes) !== null) {
            $connectedPipe = [$startY + $movement[0], $startX + $movement[1]];
            break;
        }
    }

    while ($connectedPipe !== [$startY, $startX]) {
        $distance++;
        $newPipe = moveThruPipe($input[$connectedPipe[0]][$connectedPipe[1]], $currentPosition, $connectedPipe, $pipes);
        $currentPosition = $connectedPipe;
        $connectedPipe = $newPipe;
    }


    return ($distance + 1) / 2;
}