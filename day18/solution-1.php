<?php

declare(strict_types=1);

function countOutsideSpace(&$map, $minX, $maxX, $minY, $maxY, $x, $y) {
    $directions = [
        [-1, 0],
        [0, -1],
        [0, 1],
        [1, 0],
        [-1, -1],
        [-1, 1],
        [1, -1],
        [1, 1]
    ];

    $result = 1;
    $map[$y][$x] = '#';

    foreach ($directions as $direction) {
        [$dx, $dy] = $direction;
        $newX = $x + $dx;
        $newY = $y + $dy;

        if ($newX < $minX || $newX > $maxX || $newY < $minY || $newY > $maxY) {
            continue;
        }

        if (isset($map[$newY][$newX])) {
            continue;
        }

        $result += countOutsideSpace($map, $minX, $maxX, $minY, $maxY, $newX, $newY);
    }

    return $result;
}

function solution (array $input) {
    $data = [];
    foreach ($input as $line) {
        // R 10 (#4b0942)
        [$direction, $length, $color] = explode(' ', trim($line));
        $color = str_replace(['(', ')'], '', $color);
        $data[] = [
            'direction' => $direction,
            'length' => (int) $length,
            'color' => $color,
        ];
    }

    $x = 0;
    $y = 0;

    $map[0][0] = '#';

    $maxX = $minX = $x;
    $maxY = $minY = $y;

    foreach ($data as $command) {
        for ($i = 0; $i < $command['length']; $i++) {
            switch ($command['direction']) {
                case 'R':
                    $x++;
                    break;
                case 'L':
                    $x--;
                    break;
                case 'U':
                    $y--;
                    break;
                case 'D':
                    $y++;
                    break;
            }

            $maxX = max($maxX, $x);
            $maxY = max($maxY, $y);
            $minX = min($minX, $x);
            $minY = min($minY, $y);
            $map[$y][$x] = '#';
        }
    }

    $count = countOutsideSpace($map, $minX - 1, $maxX + 1, $minY - 1, $maxY + 1, $minX - 1, $minY - 1);

//    for ($y = $minY; $y <= $maxY; $y++) {
//        for ($x = $minX; $x <= $maxX; $x++) {
//            echo $map[$y][$x] ?? '.';
//        }
//        echo PHP_EOL;
//    }

    return (abs($minX - 1 - $maxX - 1) + 1) * (abs($minY - 1 - $maxY - 1) + 1) - $count;
}