<?php

declare(strict_types=1);

function goNorth(&$map, $y, $x) {
    while (isset($map[$y - 1][$x]) && $map[$y - 1][$x] === '.') {
        $map[$y - 1][$x] = 'O';
        $map[$y][$x] = '.';
        $y--;
    }
}

function solution (array $input) {
    $map = [];
    foreach ($input as $line) {
        $map[] = str_split(trim($line));
    }

    foreach ($map as $y => $line) {
        foreach ($line as $x => $point) {
            if ($point === 'O') {
                goNorth($map, $y, $x);
            }
        }
    }

    $result = 0;
    foreach ($map as $y => $line) {
        $load = count($map) - $y;
        foreach ($line as $x => $point) {
            if ($point === 'O') {
                $result += $load;
            }
        }
    }

    return $result;
}