<?php

declare(strict_types=1);

function solution (array $input) {
    foreach ($input as $y => $line) {
        // ...#......
        $input[$y] = str_split(trim($line));
    }

    $emptyYs = [];
    $emptyXs = [];

    foreach ($input as $y => $line) {
        if (!in_array('#', $line)) {
            $emptyYs[] = $y;
        }
    }

    $galaxies = [];

    foreach (array_keys($input[0]) as $x) {
        $empty = true;
        foreach (array_keys($input) as $y) {
            if ($input[$y][$x] === '#') {
                $empty = false;

                $galaxies[] = ['y' => $y, 'x' => $x];
            }
        }

        if ($empty) {
            $emptyXs[] = $x;
        }
    }

    $distances = [];
    for ($i = 0, $c = count($galaxies) - 1; $i <= $c; $i++) {
        for ($j = $i + 1; $j <= $c; $j++) {
            $distance = [
                'distance' => abs($galaxies[$i]['x'] - $galaxies[$j]['x']) + abs($galaxies[$i]['y'] - $galaxies[$j]['y']),
                'between' => [$i, $j],
                'void' => 0,
            ];

            for ($x = min($galaxies[$i]['x'], $galaxies[$j]['x']), $limit = max($galaxies[$i]['x'], $galaxies[$j]['x']); $x <= $limit; $x++) {
                if (in_array($x, $emptyXs)) {
                    $distance['void']++;
                }
            }

            for ($y = min($galaxies[$i]['y'], $galaxies[$j]['y']), $limit = max($galaxies[$i]['y'], $galaxies[$j]['y']); $y <= $limit; $y++) {
                if (in_array($y, $emptyYs)) {
                    $distance['void']++;
                }
            }

            $distances["{$i}-{$j}"] = $distance;
        }
    }

    $result = 0;

    foreach ($distances as $distance) {
        $result += $distance['void'] + $distance['distance'];
    }

    return $result;
}