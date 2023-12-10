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
        $input[$y] = str_split(trim($line));

        foreach ($input[$y] as $x => $value) {
            if ($value === 'S') {
                $startX = $x;
                $startY = $y;
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

    $connectedToStart = $connectedPipe;

    $path = [];
    $path[$startY][$startX] = true;

    while ($connectedPipe !== [$startY, $startX]) {
        $newPipe = moveThruPipe($input[$connectedPipe[0]][$connectedPipe[1]], $currentPosition, $connectedPipe, $pipes);
        $currentPosition = $connectedPipe;
        $path[$currentPosition[0]][$currentPosition[1]] = true;
        $connectedPipe = $newPipe;
    }

    $movements = [
        [
            $currentPosition[0] - $startY,
            $currentPosition[1] - $startX,
        ],
        [
            $connectedToStart[0] - $startY,
            $connectedToStart[1] - $startX,
        ]
    ];
    foreach ($pipes as $type => $typeMoves) {
        if ($typeMoves[0] === $movements[0] && $typeMoves[1] === $movements[1]) {
            $input[$startY][$startX] = $type;
            break;
        }

        if ($typeMoves[0] === $movements[1] && $typeMoves[1] === $movements[0]) {
            $input[$startY][$startX] = $type;
            break;
        }
    }

    $result = 0;
    $inside = false;
    foreach ($input as $y => $line) {
        $lineStarted = false;
        $beginSymbol = false;
        foreach ($line as $x => $point) {
            if (isset($path[$y][$x])) {
                switch ($point) {
                    case '|':
                        $inside = !$inside;
                        break;
                    case 'L':
                        if ($lineStarted) {
                            echo 'error';
                        }
                        $beginSymbol = 'L';
                        $lineStarted = true;
                        break;
                    case 'F':
                        if ($lineStarted) {
                            echo 'error';
                        }
                        $beginSymbol = 'F';
                        $lineStarted = true;
                        break;
                    case 'J':
                        if (!$lineStarted) {
                            echo 'error';
                        }
                        $lineStarted = false;
                        if ($beginSymbol === 'F') {
                            $inside = !$inside;
                        }
                        break;
                    case '7':
                        if (!$lineStarted) {
                            echo 'error';
                        }
                        $lineStarted = false;
                        if ($beginSymbol === 'L') {
                            $inside = !$inside;
                        }
                        break;
                }
            } elseif ($inside) {
                $result++;
                $points[$y][$x] = true;
            }
        }
    }


    return $result;
}